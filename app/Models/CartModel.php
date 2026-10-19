<?php

class CartModel extends z_model
{
    public function assertCartExists(): array {
        $anonId = request()->getCookie("shoppingCardId") ?: null;
        $userId = user()?->userId ?? null;

        // Try using the anonId
        if(!is_null($anonId)) {
            $cart = model("Cart")->getCartByAnonId($anonId);
            if(!is_null($cart)) {
                // Cart found, user not logged in
                if(is_null($userId)) return $cart;

                // Cart found, user logged in, nothing to move: use the user's own cart
                if($this->getAmountItemsByCartId($cart["id"]) >= 1) {
                    // Cart found, user logged in, not yet moved to user
                    $sql = "UPDATE `cart` SET `user_id` = ? WHERE `id` = ?";
                    $this->exec($sql, "ii", $userId, $cart["id"]);

                    response()->unsetCookie("shoppingCardId");

                    return $cart;
                }
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

    public function setDiscountByCartId(int $cartId, ?int $discountId): void {
        $sql = "UPDATE `cart`
                LEFT JOIN `order` ON `order`.`cart_id` = `cart`.`id`
                SET `cart`.`discount_id` = ?
                WHERE `cart`.`id` = ? AND `order`.`id` IS NULL";
        $this->exec($sql, "ii", $discountId, $cartId);
    }

    public function getDiscountByCartId(int $cartId): ?array {
        $sql = "SELECT `discount`.*
                FROM `cart`
                JOIN `discount` ON `discount`.`id` = `cart`.`discount_id`
                WHERE `cart`.`id` = ?";
        return $this->exec($sql, "i", $cartId)->resultToLine();
    }

    public function getPriceTaxes(int $cartId, array $cartItems): array {
        $priceTaxes = App\Helper\OrderState::orderPriceTaxes($cartItems);
        $priceTaxes["discountMessage"] = null;
        $discount = $this->getDiscountByCartId($cartId);

        if ($discount === null) return $priceTaxes;

        $error = model("Discount")->getDiscountError($discount, $priceTaxes["subtotal"]);
        if ($error !== null || empty($cartItems)) {
            $priceTaxes["discountMessage"] = $error ?? "Der Rabattcode wurde aus dem leeren Warenkorb entfernt.";
            return $priceTaxes;
        }

        $priceTaxes = App\Helper\OrderState::orderPriceTaxes($cartItems, $discount);
        $priceTaxes["discountMessage"] = null;
        return $priceTaxes;
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
                AND `cart`.`user_id` IS NULL
                AND `order`.`id` IS NULL
                ORDER BY `cart`.`id` DESC
                LIMIT 1";
        return $this->exec($sql, "s", $anonId)->resultToLine();
    }

    public function addItem($cartId, $itemId): void {
        $sql = "SELECT `quantity`
                FROM `cart_item`
                WHERE `cart_id` = ? AND `item_id` = ?";
        $alreadyExisting = $this->exec($sql, "ii", $cartId, $itemId)->resultToLine();

        if ($alreadyExisting === null) {
            $sql = "INSERT INTO `cart_item` (`cart_id`, `item_id`, `quantity`)
                        SELECT ?, `item`.`id`, 1
                        FROM `item`
                        JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                        JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                        WHERE `item`.`id` = ? AND `item`.`active` = 1 AND `item`.`stock` >= 1
                        AND `catalog`.`active` = 1 AND `brand`.`active` = 1";
            $this->exec($sql, "ii", $cartId, $itemId);
        } else {
            $sql = "UPDATE `cart_item`
                    JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                    JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                    JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                    SET `cart_item`.`quantity` = `cart_item`.`quantity` + 1
                    WHERE `cart_item`.`cart_id` = ? AND `cart_item`.`item_id` = ?
                    AND `cart_item`.`quantity` + 1 <= `item`.`stock`
                    AND `catalog`.`active` = 1 AND `brand`.`active` = 1";
            $this->exec($sql, "ii", $cartId, $itemId);
        }
    }

    public function getAmountItemsByCartId(int $cartId): ?int {
        $sql = "SELECT COUNT(*) AS `amount`
                FROM `cart_item`
                WHERE `cart_item`.`cart_id` = ?";
        return $this->exec($sql, "i", $cartId)->resultToLine()["amount"] ?? null;
    }

    public function getItems(): array {
        $cart = $this->assertCartExists();

        $sql = "SELECT
                    `cart_item`.`id` AS `cart_item_id`,
                    `cart_item`.`quantity`,
                    `item`.`id` AS `item_id`,
                    `item`.`size`,
                    `item`.`color`,
                    `item`.`price`,
                    `item`.`stock`,
                    `item`.`taxrate` AS `taxrate`,
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
                AND `catalog`.`active` = 1 AND `brand`.`active` = 1
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $cart["id"])->resultToArray();
    }

    public function deleteCartItemById(int $cartItemId): void {
        $cart = $this->assertCartExists();
        $sql = "DELETE FROM `cart_item` WHERE `id` = ? AND `cart_id` = ?";
        $this->exec($sql, "ii", $cartItemId, $cart["id"]);
    }

    public function raiseCartItemById(int $cartItemId): void {
        $cart = $this->assertCartExists();
        $sql = "UPDATE `cart_item`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                SET `cart_item`.`quantity` = `cart_item`.`quantity` + 1
                WHERE `cart_item`.`id` = ? AND `cart_item`.`cart_id` = ?
                AND `cart_item`.`quantity` + 1 <= `item`.`stock`";
        $this->exec($sql, "ii", $cartItemId, $cart["id"]);
    }

    public function reduceCartItemById(int $cartItemId): void {
        $cart = $this->assertCartExists();
        $currentItem = $this->exec("SELECT `quantity` FROM `cart_item` WHERE `id` = ? AND `cart_id` = ?", "ii", $cartItemId, $cart["id"])->resultToLine();
        if ($currentItem && $currentItem["quantity"] <= 1)
            {
                $this->deleteCartItemById($cartItemId);
            } else {
                $sql = "UPDATE `cart_item` SET `quantity` = `quantity` - 1 WHERE `id` = ? AND `cart_id` = ?";
                $this->exec($sql, "ii", $cartItemId, $cart["id"]);
            }
    }

    public function getCartItemQuantityById(int $cartItemId): ?int {
        $cart = $this->assertCartExists();
        $sql = "SELECT `quantity` FROM `cart_item` WHERE `id` = ? AND `cart_id` = ?";
        return $this->exec($sql, "ii", $cartItemId, $cart["id"])->resultToLine()["quantity"] ?? null;
    }

    public function getItemsByCartId(int $cartId): array {
        $sql = "SELECT
                    `cart_item`.`id` AS `cart_item_id`,
                    `cart_item`.`quantity`,
                    `item`.`id` AS `item_id`,
                    `item`.`size`,
                    `item`.`color`,
                    `item`.`price`,
                    `item`.`stock`,
                    `item`.`taxrate`,
                    `catalog`.`id` AS `catalog_id`,
                    `catalog`.`name` AS `catalog_name`,
                    `catalog`.`itemable_type`,
                    `brand`.`name` AS `brand_name`,
                    `z_user`.`email` AS `user_email`
                FROM `cart`
                JOIN `cart_item` ON `cart_item`.`cart_id` = `cart`.`id`
                JOIN `item` ON `item`.`id` = `cart_item`.`item_id`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                LEFT JOIN `z_user` ON `z_user`.`id` = `cart`.`user_id`
                WHERE `cart`.`id` = ?
                AND `item`.`active` = 1
                AND `catalog`.`active` = 1 AND `brand`.`active` = 1
                ORDER BY `cart_item`.`created` ASC";

        return $this->exec($sql, "i", $cartId)->resultToArray();
    }
}
