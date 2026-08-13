<?php

class ItemModel extends z_model
{

    public function getItemById($itemId): array
    {
        $sql = "SELECT * FROM `item` WHERE `id` = ?";
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
}
