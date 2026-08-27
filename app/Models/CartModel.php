<?php

class CartModel extends z_model
{
    public function getCartByUserId($userId): array
    {
        $sql = "SELECT `id` FROM `cart` WHERE `user_id` = ?";
        return $this->exec($sql, "i", $userId)->resultToLine();
    }

    public function createCart($userId): void
    {
        $sql = "INSERT INTO `cart` (`user_id`) VALUES (?)";
        $this->exec($sql, "i", $userId);
    }

    public function addItem($cartId, $itemId): void
    {
        $sql = "INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`)
                SELECT ?, `id`, 1
                FROM `item`
                WHERE `id` = ? AND `active` = 1";
        $this->exec($sql, "ii", $cartId, $itemId);
    }

    public function getItemsByUserId($userId): array
    {
        $sql = "SELECT
                    `cart_item`.`id` AS `cart_item_id`,
                    `cart_item`.`quantity`,
                    `item`.`id` AS `item_id`,
                    `item`.`size`,
                    `item`.`color`,
                    `item`.`price`,
                    `item`.`stock`,
                    `catalog`.`id` AS `catalog_id`,
                    `catalog`.`name` AS `catalog_name`,
                    `catalog`.`itemable_type`,
                    `brand`.`name` AS `brand_name`
                FROM `cart`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                WHERE `cart`.`user_id` = ?
                AND `item`.`active` = 1
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $userId)->resultToArray();
    }
}
