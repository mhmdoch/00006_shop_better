<?php

class OrderModel extends z_model
{
    public function createOrder($cartId, $addressForm, string $token): int {

        $cartItemList = [];

        $sql = "SELECT `ci`.`item_id` AS `item_id`,
                       `ci`.`quantity` AS `quantity`,
                       `i`.`stock` AS `stock`,
                       `i`.`price`,
                       `i`.`taxrate`
                FROM `cart_item` AS `ci`
                JOIN `item`AS i ON `i`.`id` = `ci`.`item_id`
                WHERE `ci`.`cart_id` = ? AND `i`.`active` = 1";

        $cartItems = $this->exec($sql, "i", $cartId)->resultToArray();

        if (empty($cartItems)) throw new Exception("Dein Warenkorb ist leer.");

        $priceTaxes = model("Cart")->getPriceTaxes($cartId, $cartItems);
        if ($priceTaxes["discountMessage"] !== null) {
            throw new Exception($priceTaxes["discountMessage"]);
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem["stock"] < $cartItem["quantity"]) {
                throw new Exception("Lagerbestand reicht nicht aus.");
            }

            $cartItemList[$cartItem["item_id"]] = [
                "quantity" => $cartItem["quantity"],
                "stock"    => $cartItem["stock"],
                "price"    => $cartItem["price"],
                "taxrate"  => $cartItem["taxrate"],
            ];
        }


        $this->reserveStock($cartItemList);

        try {
            $orderId = $this->insertOrder($cartId, $cartItemList, $addressForm, $token);
        } catch (Throwable $e) {
            $this->releaseStock($cartItemList);
            throw $e;
        }

        return $orderId;

    }


    /**
     * Takes the stock for all items or none. A concurrent order may have
     * taken it since the check in createOrder, so every item is checked again.
     */
    private function reserveStock(array $cartItemList): void {
        $reserved = [];

        foreach ($cartItemList as $itemId => $cartItem) {
            $sql = "UPDATE `item`
                    SET `stock` = `stock` - ?
                    WHERE `id` = ? AND `stock` >= ?";
            $this->exec($sql, "iii", $cartItem["quantity"], $itemId, $cartItem["quantity"]);

            $changed = (int) $this->exec("SELECT ROW_COUNT() AS `changed`")->resultToLine()["changed"];
            if ($changed !== 1) {
                $this->releaseStock($reserved);
                throw new Exception("Lagerbestand reicht nicht aus.");
            }

            $reserved[$itemId] = $cartItem;
        }
    }

    private function releaseStock(array $cartItemList): void {
        foreach ($cartItemList as $itemId => $cartItem) {
            $sql = "UPDATE `item` SET `stock` = `stock` + ? WHERE `id` = ?";
            $this->exec($sql, "ii", $cartItem["quantity"], $itemId);
        }
    }

    private function insertOrder($cartId, array $cartItemList, $addressForm, string $token): int {
        foreach ($cartItemList as $itemId => $cartItem) {
            $sql = "UPDATE `cart_item` SET `price` = ?, `taxrate` = ?
                    WHERE `cart_id` = ? AND `item_id` = ?";
            $this->exec($sql, "ssii", $cartItem["price"], $cartItem["taxrate"], $cartId, $itemId);
        }

        $orderNumber = "ORD-" . date("Ymd") . "-" . str_pad($cartId, 6, "0", STR_PAD_LEFT);

        $sql = "INSERT INTO `order` (
            `cart_id`, `order_number`, `email`, `recipient`,
            `address_line_1`, `address_line_2`,
            `postal_code`, `city`, `country`, `token`, `status`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

        return $this->exec(
            $sql,
            "isssssssss",
            $cartId,
            $orderNumber,
            $addressForm->getValue("email"),
            $addressForm->getValue("recipient"),
            $addressForm->getValue("address_line_1"),
            $addressForm->getValue("address_line_2"),
            $addressForm->getValue("postal_code"),
            $addressForm->getValue("city"),
            $addressForm->getValue("country"),
            $token,
        )->getInsertId();
    }


    /**
     * Changes the status only if the order is still in the expected one.
     * Only one of several concurrent calls wins, so a cancellation gives
     * the stock back exactly once.
     * @return bool False if the order was changed in the meantime
     */
    public function changeStatus(int $orderId, string $fromStatus, string $toStatus): bool {
        $sql = "UPDATE `order`
                SET `status` = ?
                WHERE `id` = ? AND `status` = ?";
        $this->exec($sql, "sis", $toStatus, $orderId, $fromStatus);

        $changed = (int) $this->exec("SELECT ROW_COUNT() AS `changed`")->resultToLine()["changed"];
        if ($changed !== 1) return false;

        if ($toStatus === "cancelled") {
            $this->restockOrder($orderId);
        }

        return true;
    }

    private function restockOrder($orderId): void {
        $sql = "SELECT `cart_item`.`item_id`, `cart_item`.`quantity`
                FROM `order`
                JOIN `cart_item`
                ON `cart_item`.`cart_id` = `order`.`cart_id`
                WHERE `order`.`id` = ? AND `cart_item`.`price` IS NOT NULL";

        $cartItems = $this->exec($sql, "i", $orderId)->resultToArray();

        foreach ($cartItems as $cartItem) {
            $sql = "UPDATE `item`
                    SET `stock` = `stock` + ?
                    WHERE `id` = ?";

            $this->exec($sql, "ii", $cartItem["quantity"], $cartItem["item_id"]);
        }
    }


    public function getOrders(): array {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`cart_item`.`price` * `cart_item`.`quantity`) - LEAST(
                        SUM(`cart_item`.`price` * `cart_item`.`quantity`),
                        CASE WHEN `discount`.`type` = 'percent'
                            THEN ROUND(SUM(`cart_item`.`price` * `cart_item`.`quantity`) * `discount`.`value` / 100, 2)
                            ELSE COALESCE(`discount`.`value`, 0)
                        END
                    ) AS `total`
                FROM `order`
                JOIN `cart`
                ON `cart`.`id` = `order`.`cart_id`
                JOIN `cart_item`
                ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item`
                ON `item`.`id` = `cart_item`.`item_id`
                LEFT JOIN `discount` ON `discount`.`id` = `cart`.`discount_id`
                WHERE `cart_item`.`price` IS NOT NULL
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql)->resultToArray();
    }

    public function getOrdersByUserId($userId): array {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`cart_item`.`price` * `cart_item`.`quantity`) - LEAST(
                        SUM(`cart_item`.`price` * `cart_item`.`quantity`),
                        CASE WHEN `discount`.`type` = 'percent'
                            THEN ROUND(SUM(`cart_item`.`price` * `cart_item`.`quantity`) * `discount`.`value` / 100, 2)
                            ELSE COALESCE(`discount`.`value`, 0)
                        END
                    ) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                LEFT JOIN `discount` ON `discount`.`id` = `cart`.`discount_id`
                WHERE `cart`.`user_id` = ?
                AND `cart_item`.`price` IS NOT NULL
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql, "i", $userId)->resultToArray();
    }

    public function getOrderById($orderId): ?array {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    `cart`.`anon_id`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                WHERE `order`.`id` = ?
                LIMIT 1";

        return $this->exec($sql, "i", $orderId)->resultToLine();
    }

    public function getItemsByOrderId($orderId): array {
        $sql = "SELECT
                    `cart_item`.`quantity`,
                    `item`.`id` AS `item_id`,
                    `item`.`size`,
                    `item`.`color`,
                    `cart_item`.`price`,
                    `cart_item`.`taxrate`,
                    `catalog`.`id` AS `catalog_id`,
                    `catalog`.`name` AS `catalog_name`,
                    `catalog`.`itemable_type`,
                    `brand`.`name` AS `brand_name`
                FROM `order`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `order`.`cart_id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                WHERE `order`.`id` = ?
                AND `cart_item`.`price` IS NOT NULL
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $orderId)->resultToArray();
    }

    public function deleteLostCartItems(int $itemId): void {
        $sql = "DELETE `cart_item` FROM `cart_item`
                LEFT JOIN `order` ON `order`.`cart_id` = `cart_item`.`cart_id`
                WHERE `cart_item`.`item_id` = ?
                AND `order`.`id` IS NULL";

        $this->exec($sql, "i", $itemId);
    }

    public function getOrderByToken(string $token): ?array {
        $sql = "SELECT *
                FROM `order`
                WHERE `token` = ?
                LIMIT 1";
        return $this->exec($sql, "s", $token)->resultToLine();
    }
}
