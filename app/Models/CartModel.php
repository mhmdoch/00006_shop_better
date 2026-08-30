<?php

class CartModel extends z_model
{
    public function assertCartExists(): array
    {
        $anonId = request()->getCookie("shoppingCardId") ?: null;
        $userId = user()?->userId ?? null;

        // Try using the anonId
        if(!is_null($anonId)) {
            $cart = model("Cart")->getCartByAnonId($anonId);
            if(!is_null($cart)) {
                // Cart found, user not logged in
                if(is_null($userId)) return $cart;

                // Cart found, user logged in, already moved to user
                if(!is_null($cart["user_id"])) return $cart;

                // Get item count
                $itemCount = $this->getAmountItemsByCartId($cart["id"]);
                if($itemCount < 1) return $cart;

                // Cart found, user logged in, not yet moved to user
                $sql = "UPDATE `cart` SET `user_id` = ? WHERE `id` = ?";
                $this->exec($sql, "ii", $userId, $cart["id"]);

                response()->unsetCookie("shoppingCardId");

                return $cart;
            }
        }

        // Try using the userId
        if(!is_null($userId)) {
            $cart = model("Cart")->getCartByUserId($userId);
            if(!is_null($cart)) {
                return $cart;
            }

            $sql = "INSERT INTO `cart` (`user_id`) VALUES (?)";
            $cartId = $this->exec($sql, "i", $userId)->getInsertId();
            return $this->getCartById($cartId);
        }

        // Otherwise create one and return it
        $sql = "INSERT INTO `cart` (`anon_id`) VALUES (?)";
        $cartId = $this->exec($sql, "s", $anonId)->getInsertId();
        return $this->getCartById($cartId);
    }

    public function getCartById(int $cartId): ?array {
        $sql = "SELECT * FROM `cart` WHERE `id` = ? LIMIT 1";
        return $this->exec($sql, "i", $cartId)->resultToLine();
    }

    public function getCartByUserId(int $userId): ?array {
        $sql = "SELECT `cart`.*
                FROM `cart`
                LEFT JOIN `order` ON `order`.`cart_id` = `cart`.`id`
                WHERE `cart`.`user_id` = ?
                AND `order`.`id` IS NULL
                ORDER BY `cart`.`id` DESC
                LIMIT 1";
        return $this->exec($sql, "i", $userId)->resultToLine();
    }

    public function getCartByAnonId(string $anonId): ?array {
        $sql = "SELECT `cart`.*
                FROM `cart`
                LEFT JOIN `order` ON `order`.`cart_id` = `cart`.`id`
                WHERE `cart`.`anon_id` = ?
                AND `order`.`id` IS NULL
                ORDER BY `cart`.`id` DESC
                LIMIT 1";
        return $this->exec($sql, "s", $anonId)->resultToLine();
    }

    public function addItem($cartId, $itemId): void
    {
        $sql = "INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`)
                SELECT ?, `id`, 1
                FROM `item`
                WHERE `id` = ? AND `active` = 1";
        $this->exec($sql, "ii", $cartId, $itemId);
    }

    public function getAmountItemsByCartId(int $cartId): ?int {
        $sql = "SELECT COUNT(*) AS `amount`
                FROM `cart_item`
                WHERE `cart_item`.`cart_id` = ?";
        return $this->exec($sql, "i", $cartId)->resultToLine()["amount"] ?? null;
    }

    public function getItems(): array
    {
        $cart = $this->assertCartExists();

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
                WHERE `cart`.`id` = ?
                AND `item`.`active` = 1
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $cart["id"])->resultToArray();
    }
}
