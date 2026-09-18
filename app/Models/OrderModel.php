<?php

class OrderModel extends z_model
{
    public function createOrder($cartId, $addressForm): int
    {
        // Get the current stock
        // shoes 4, apples, 10

        // Reduce stock with one update query and a where
        // shoes = shoes - 3 WHERE shoes = 4
        // apples = apples - 5 WHERE apples = 10

        // Check if actually all stocks were reduced
        // select shoes, apples
        // shoes = 1, apples = 5
        // if not, throw exception

        // Do a normal order flow with simple code and foreach, no transaction

        $sql = "START TRANSACTION; 
                SELECT COUNT(*) AS `total_items` 
                FROM `cart_item` 
                WHERE `cart_id` = ?;

                SELECT `ci`.`item_id` AS `item_id`, 
                        `ci`.`quantity` AS `quantity`, 
                        `i`.`stock` AS `stock`
                FROM `cart_item` AS `ci` 
                JOIN `item`AS i ON `i`.`id` = `ci`.`item_id`
                WHERE `ci`.`cart_id` = ?
                FOR UPDATE;

                UPDATE `item` AS `i`
                JOIN `cart_item` AS `ci` ON `i`.`id` = `ci`.`item_id`
                SET `i`.`stock` = `i`.`stock` - `ci`.`quantity`
                WHERE `ci`.`cart_id` = ? 
                    AND NOT EXISTS (
                    SELECT 1
                    FROM `cart_item` AS `ci2`
                    JOIN `item` AS `i2` ON `i2`.`id` = `ci2`.`item_id`
                    WHERE `ci2`.`card_id` = ?
                    AND `i2`.`stock` < `ci2`.`quantity`
                );
                COMMIT;";

        $itemsInCart = $this->exec($sql, "i", $cartId)->resultToArray();

        //dann gucken, wieviele zeilen verändert wurden und das mit total_items vergleichen




        $cartItemList = [];

        // ich hole mir die Cart Items
        $cartItemListSQL = "SELECT `item_id`, `quantity` FROM `cart_item` WHERE `cart_id` = ?";
        $cartItemListSQLResult = $this->exec($cartItemListSQL, "i", $cartId)->resultToArray();
        

    

        // ich gehe die Cart Items der Reihe nach durch und prüfe, ob der Lagerbestand ausreicht
        foreach ($cartItemListSQLResult as $cartItem) {
            $cartItemList[] = [
                "item_id" => $cartItem["item_id"],
                "quantity" => $cartItem["quantity"]
            ];

            // hier hole ich mir den Lagerbestand des jeweiligen Items
            $itemSQL = "SELECT `stock` FROM `item` WHERE `id` = ?";
            $item = $this->exec($itemSQL, "i", $cartItem["item_id"])->resultToLine();

            // wenn der Lagerbestand kleiner ist als die Menge im Warenkorb, werfe ich eine Exception
            if ($item["stock"] < $cartItem["quantity"]) {
                throw new Exception("Lagerbestand reicht nicht aus.");
            }
        }

        $orderNumber = "ORD-" . date("Ymd") . "-" . str_pad($cartId, 6, "0", STR_PAD_LEFT);

        // da der Lagerbestand ausreicht, kann ich die Bestellung erstellen und den Lagerbestand reduzieren
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

        // hier reduziere ich den Lagerbestand der Items, die in der Bestellung enthalten sind
        $sql = "UPDATE `item`
                JOIN `cart_item` ON `cart_item`.`item_id` = `item`.`id`
                SET `item`.`stock` = `item`.`stock` - `cart_item`.`quantity`
                WHERE `cart_item`.`cart_id` = ?";
                    // AND item.stock >= cart_item.quantity
                    // mit foreach drum rum

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
