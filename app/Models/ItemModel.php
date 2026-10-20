<?php

class ItemModel extends z_model
{

    public function getItemById($itemId): array {
        $sql = "SELECT `item`.*, `catalog`.`itemable_type`
                FROM `item`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                WHERE `item`.`id` = ?";
        return $this->exec($sql, "i", $itemId)->resultToLine();
    }

    public function getItemsByCatalogId($catalogId): array {
        $sql = "SELECT * FROM `item` WHERE `catalog_id` = ? AND active = 1";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    public function getItemsByCartId($itemId): array {
        $sql = "SELECT `item`.*, `catalog`.`itemable_type`
                FROM `item`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                WHERE `item`.`id` = ?";
        return $this->exec($sql, "i", $itemId)->resultToLine();
    }

    public function getItemsByCatalogIds(array $catalogIds): array {
        $catalogIds = array_values(
            array_unique(
                array_map('intval', $catalogIds)
            )
        );

        if (empty($catalogIds)) {
            return [];
        }

        $catalogIdList = implode(', ', $catalogIds);

        $sql = "SELECT *, zf.reference AS thumb_reference, zf.extension AS thumb_extension
                FROM `item`
                JOIN `catalog` ON `item`.`catalog_id` = `catalog`.`id`
                LEFT JOIN `z_file` AS zf ON `catalog`.`titlethumb` = zf.`id`
                WHERE `catalog_id` IN ({$catalogIdList})
                AND item.`active` = 1";

        return $this->exec($sql)->resultToArray();
    }


    public function getItemShoeById($itemId): ?array {
        $sql = "SELECT `item`.*, `brand`.`name` AS `brand_name`, `catalog`.`name` AS `catalog_name`, `catalog`.`id` AS `catalog_id`
                FROM `item`
                JOIN `catalog` ON `item`.`catalog_id` = `catalog`.`id`
                JOIN `brand` ON `catalog`.`brand_id` = `brand`.`id`
                WHERE `item`.`id` = ?";
        return $this->exec($sql, "i", $itemId)->resultToLine();
    }

    /**
     * Sets the stock only if it is still the expected one.
     * @return bool False if the stock was changed in the meantime
     */
    public function changeStock(int $itemId, int $expectedStock, int $newStock): bool {
        $sql = "UPDATE `item` SET `stock` = ? WHERE `id` = ? AND `stock` = ?";
        $this->exec($sql, "iii", $newStock, $itemId, $expectedStock);

        return (int) $this->exec("SELECT ROW_COUNT() AS `changed`")->resultToLine()["changed"] === 1;
    }

    /**
     * Takes an item out of sale only if it is still active and has the expected stock.
     * @return bool False if the item was changed in the meantime
     */
    public function deactivateItem(int $itemId, int $expectedStock): bool {
        $sql = "UPDATE `item` SET `active` = 0 WHERE `id` = ? AND `active` = 1 AND `stock` = ?";
        $this->exec($sql, "ii", $itemId, $expectedStock);

        return (int) $this->exec("SELECT ROW_COUNT() AS `changed`")->resultToLine()["changed"] === 1;
    }

    public function setActive(int $itemId, bool $active): void {
        $this->exec("UPDATE `item` SET `active` = ? WHERE `id` = ?", "ii", (int) $active, $itemId);
    }

    public function setStock(int $itemId, int $stock): void {
        $this->exec("UPDATE `item` SET `stock` = ? WHERE `id` = ?", "ii", $stock, $itemId);
    }

    public function setReplacedBy(int $itemId, ?int $replacedBy): void {
        $this->exec("UPDATE `item` SET `replaced_by` = ? WHERE `id` = ?", "ii", $replacedBy, $itemId);
    }

    /**
     * Old versions of a variant that a newer one has replaced, newest first.
     */
    public function getReplacedItemsByCatalogId(int $catalogId): array {
        $sql = "SELECT * FROM `item`
                WHERE `catalog_id` = ? AND `active` = 0 AND `replaced_by` IS NOT NULL
                ORDER BY `id` DESC";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    /**
     * Follows the chain of replacements from an old version to the version that is on sale now.
     * @return int|null Null if there is none, for example for versions from before the chain was recorded
     */
    public function getCurrentVersionId(int $itemId): ?int {
        $currentId = $itemId;

        // The limit only guards against a broken chain that leads in a circle
        for ($step = 0; $step < 100; $step++) {
            $row = $this->exec("SELECT `active`, `replaced_by` FROM `item` WHERE `id` = ?", "i", $currentId)->resultToLine();
            if ($row === null) return null;
            if ($currentId !== $itemId && (int) $row["active"] === 1) return $currentId;
            if ($row["replaced_by"] === null) return null;
            $currentId = (int) $row["replaced_by"];
        }

        return null;
    }

    /**
     * Puts an old version back on sale with the given stock, only if it is still inactive.
     * @return bool False if the item was changed in the meantime
     */
    public function activateReplaced(int $itemId, int $stock): bool {
        $sql = "UPDATE `item` SET `active` = 1, `replaced_by` = NULL, `stock` = ?
                WHERE `id` = ? AND `active` = 0";
        $this->exec($sql, "ii", $stock, $itemId);

        return (int) $this->exec("SELECT ROW_COUNT() AS `changed`")->resultToLine()["changed"] === 1;
    }

    /**
     * Items on sale that are almost or fully sold out, the emptiest first.
     */
    public function getLowStockItems(int $maxStock, int $limit): array {
        $sql = "SELECT `item`.`id`, `item`.`stock`, `item`.`size`, `item`.`color`, `item`.`name` AS `item_name`,
                       `catalog`.`id` AS `catalog_id`, `catalog`.`name` AS `catalog_name`, `brand`.`name` AS `brand_name`
                FROM `item`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                JOIN `brand` ON `brand`.`id` = `catalog`.`brand_id`
                WHERE `item`.`active` = 1 AND `catalog`.`active` = 1 AND `item`.`stock` <= ?
                ORDER BY `item`.`stock` ASC, `item`.`id` ASC
                LIMIT ?";
        return $this->exec($sql, "ii", $maxStock, $limit)->resultToArray();
    }

    public function countLowStockItems(int $maxStock): int {
        $sql = "SELECT COUNT(*) AS `amount`
                FROM `item`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                WHERE `item`.`active` = 1 AND `catalog`.`active` = 1 AND `item`.`stock` <= ?";
        return (int) $this->exec($sql, "i", $maxStock)->resultToLine()["amount"];
    }
}
