<?php

class OrderModel extends z_model
{
    public function createOrder($cartId, $addressForm): int
    {
        // Get the current stock
        // shoes 4, apples, 10

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

        // Reduce stock with one update query and a where
        // shoes = shoes - 3 WHERE shoes = 4
        // apples = apples - 5 WHERE apples = 10

        foreach ($cartItemList as $itemId => $cartItem) {
            $sql = "UPDATE `item`
                    SET `stock` = `stock` - ?
                    WHERE `id` = ? AND `stock` >= ?";

            $this->exec($sql, "iii", $cartItem["quantity"], $itemId, $cartItem["quantity"]);
        }

        // Check if actually all stocks were reduced
        // select shoes, apples
        // shoes = 1, apples = 5
        // if not, throw exception

        // Do a normal order flow with simple code and foreach, no transaction

        $orderItemList = [];

        $sql = "SELECT `ci`.`item_id` AS `item_id`, 
                       `ci`.`quantity` AS `quantity`, 
                       `i`.`stock` AS `stock`
                FROM `cart_item` AS `ci` 
                JOIN `item`AS i ON `i`.`id` = `ci`.`item_id`
                WHERE `ci`.`cart_id` = ?";

        $orderItems = $this->exec($sql, "i", $cartId)->resultToArray();

        // getting a new list of the items with changed stock

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
                    `cart_id`,
                    `order_number`,
                    `recipient`,
                    `address_line_1`,
                    `address_line_2`,
                    `postal_code`,
                    `city`,
                    `country`,
                    `status`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        $orderId = $this->exec(
            $sql,
            "isssssss",
            $cartId,
            $orderNumber,
            $addressForm->getValue("recipient"),
            $addressForm->getValue("address_line_1"),
            $addressForm->getValue("address_line_2"),
            $addressForm->getValue("postal_code"),
            $addressForm->getValue("city"),
            $addressForm->getValue("country"),
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
                    `z_user`.`email`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`item`.`price` * `cart_item`.`quantity`) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                LEFT JOIN `z_user` ON `z_user`.`id` = `cart`.`user_id`
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
                    `z_user`.`email`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`item`.`price` * `cart_item`.`quantity`) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                LEFT JOIN `z_user` ON `z_user`.`id` = `cart`.`user_id`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                WHERE `cart`.`user_id` = ?
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql, "i", $userId)->resultToArray();
    }

    public function getOrderById($orderId): array
    {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    `z_user`.`email`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                LEFT JOIN `z_user` ON `z_user`.`id` = `cart`.`user_id`
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
}
