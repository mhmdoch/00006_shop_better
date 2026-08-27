<?php

class ItemModel extends z_model
{

    public function getItemById($itemId): array
    {
        $sql = "SELECT `item`.*, `catalog`.`itemable_type`
                FROM `item`
                JOIN `catalog` ON `catalog`.`id` = `item`.`catalog_id`
                WHERE `item`.`id` = ?";
        return $this->exec($sql, "i", $itemId)->resultToLine();
    }

    public function getItemsByCatalogId($catalogId): array
    {
        $sql = "SELECT * FROM `item` WHERE `catalog_id` = ? AND active = 1";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    public function getItemsByCatalogIds(array $catalogIds): array
    {
        $catalogIds = array_values(
            array_unique(
                array_map('intval', $catalogIds)
            )
        );

        if (empty($catalogIds)) {
            return [];
        }

        $catalogIdList = implode(', ', $catalogIds);

        $sql = "SELECT *
        FROM `item`
        WHERE `catalog_id` IN ({$catalogIdList})
        AND `active` = 1";

        return $this->exec($sql)->resultToArray();
    }


    public function getItemShoeById($itemId): array
    {
        $sql = "SELECT `item`.*, `brand`.`name` AS `brand_name`, `catalog`.`name` AS `catalog_name`, `catalog`.`id` AS `catalog_id`
                FROM `item`
                JOIN `catalog` ON `item`.`catalog_id` = `catalog`.`id`
                JOIN `brand` ON `catalog`.`brand_id` = `brand`.`id`
                WHERE `item`.`id` = ?";
        return $this->exec($sql, "i", $itemId)->resultToLine();
    }
}
