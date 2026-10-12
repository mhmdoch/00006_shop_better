<?php

class OrderModel extends z_model
{
    public function createOrder($cartId, $addressForm, string $token): int
    {

        $cartItemList = [];

        $sql = "SELECT `ci`.`item_id` AS `item_id`, 
                       `ci`.`quantity` AS `quantity`, 
                       `i`.`stock` AS `stock`
                FROM `cart_item` AS `ci` 
                JOIN `item`AS i ON `i`.`id` = `ci`.`item_id`
                WHERE `ci`.`cart_id` = ?";

        $cartItems = $this->exec($sql, "i", $cartId)->resultToArray();

        foreach ($cartItems as $cartItem) {
            if ($cartItem["stock"] < $cartItem["quantity"]) {
                throw new Exception("Lagerbestand reicht nicht aus.");
            }

            $cartItemList[$cartItem["item_id"]] = [
                "quantity" => $cartItem["quantity"],
                "stock"    => $cartItem["stock"]
            ];
        }


        foreach ($cartItemList as $itemId => $cartItem) {
            $sql = "UPDATE `item`
                    SET `stock` = `stock` - ?
                    WHERE `id` = ? AND `stock` >= ?";

            $this->exec($sql, "iii", $cartItem["quantity"], $itemId, $cartItem["quantity"]);
        }

        $orderItemList = [];

        $sql = "SELECT `ci`.`item_id` AS `item_id`, 
                       `ci`.`quantity` AS `quantity`, 
                       `i`.`stock` AS `stock`
                FROM `cart_item` AS `ci` 
                JOIN `item`AS i ON `i`.`id` = `ci`.`item_id`
                WHERE `ci`.`cart_id` = ?";

        $orderItems = $this->exec($sql, "i", $cartId)->resultToArray();


        foreach ($orderItems as $orderItem) {
            $orderItemList[$orderItem["item_id"]] = [
                "quantity" => $orderItem["quantity"],
                "stock"    => $orderItem["stock"]
            ];
        }

        foreach ($orderItemList as $itemId => $orderItem) {
                if ($orderItem['stock'] != $cartItemList[$itemId]['stock'] - $orderItem['quantity']) {
                    throw new Exception("Lagerbestand reicht nicht aus.");
                }
        }

        $orderNumber = "ORD-" . date("Ymd") . "-" . str_pad($cartId, 6, "0", STR_PAD_LEFT);

        $sql = "INSERT INTO `order` (
            `cart_id`, `order_number`, `email`, `recipient`,
            `address_line_1`, `address_line_2`,
            `postal_code`, `city`, `country`, `token`, `status`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

        $orderId = $this->exec(
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

        return $orderId;

    }


    public function restockOrder($orderId): void
    {
        $sql = "SELECT `cart_item`.`item_id`, `cart_item`.`quantity`
                FROM `order`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `order`.`cart_id`
                WHERE `order`.`id` = ?";

        $cartItems = $this->exec($sql, "i", $orderId)->resultToArray();

        foreach ($cartItems as $cartItem) {
            $sql = "UPDATE `item`
                    SET `stock` = `stock` + ?
                    WHERE `id` = ?";

            $this->exec($sql, "ii", $cartItem["quantity"], $cartItem["item_id"]);
        }
    }


    public function getOrders(): array
    {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`item`.`price` * `cart_item`.`quantity`) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql)->resultToArray();
    }

    public function getOrdersByUserId($userId): array
    {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`item`.`price` * `cart_item`.`quantity`) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                WHERE `cart`.`user_id` = ?
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql, "i", $userId)->resultToArray();
    }

    public function getOrderById($orderId): ?array
    {
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

    public function getItemsByOrderId($orderId): array
    {
        $sql = "SELECT
                    `cart_item`.`quantity`,
                    `item`.`id` AS `item_id`,
                    `item`.`size`,
                    `item`.`color`,
                    `item`.`price`,
                    `item`.`taxrate` AS `taxrate`,
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
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $orderId)->resultToArray();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $sql = "UPDATE `order`
                SET `status` = ?
                WHERE `id` = ?";

        $this->exec($sql, "si", $status, $orderId);
    }

    public function deleteLostCartItems(int $itemId): void
    {
    $sql = "DELETE FROM `cart_item`
            LEFT JOIN `order` ON `order`.`cart_id` = `cart_item`.`cart_id`
            WHERE `cart_item`.`item_id` = ?
            AND `order`.`id` IS NULL";

    $this->exec($sql, "i", $itemId);
    }

    public function getOrderByToken(string $token): ?array
    {
    $sql = "SELECT `order`.*
            FROM `order`
            WHERE `token` = ?
            LIMIT 1";

    return $this->exec($sql, "s", $token)->resultToLine();
    }
}
