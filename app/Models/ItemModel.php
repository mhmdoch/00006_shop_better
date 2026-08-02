<?php

class ItemModel extends z_model
{

    public function getItemsByCatalogId($catalogId): array
    {
        $sql = "SELECT * FROM `item` WHERE `catalog_id` = ? AND is_active = 1";
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
        AND `is_active` = 1";

        return $this->exec($sql)->resultToArray();
    }
}
