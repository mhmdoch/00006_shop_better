<?php

class OrderModel extends z_model
{
    public function getOrders(): array
    {
        $sql = "SELECT
                    `order`.*,
                    `cart`.`user_id`,
                    `z_user`.`email`,
                    `address`.`recipient`,
                    `address`.`address_line_1`,
                    `address`.`address_line_2`,
                    `address`.`postal_code`,
                    `address`.`city`,
                    `address`.`country_code`,
                    SUM(`cart_item`.`quantity`) AS `quantity`,
                    SUM(`item`.`price` * `cart_item`.`quantity`) AS `total`
                FROM `order`
                JOIN `cart` ON `cart`.`id` = `order`.`cart_id`
                LEFT JOIN `z_user` ON `z_user`.`id` = `cart`.`user_id`
                JOIN `address` ON `address`.`id` = `order`.`shipping_address_id`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                GROUP BY `order`.`id`
                ORDER BY `order`.`created` DESC";

        return $this->exec($sql)->resultToArray();
    }
}
