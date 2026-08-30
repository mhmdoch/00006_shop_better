<?php

class OrderModel extends z_model
{
    public function createOrder($cartId, $addressForm): int
    {
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

        $sql = "UPDATE `item`
                JOIN `cart_item` ON `cart_item`.`item_id` = `item`.`id`
                SET `item`.`stock` = `item`.`stock` - `cart_item`.`quantity`
                WHERE `cart_item`.`cart_id` = ?";

        $this->exec($sql, "i", $cartId);

        return $orderId;
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
}
