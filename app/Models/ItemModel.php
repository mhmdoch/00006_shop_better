<?php

class ItemModel extends z_model
{

    public function getItemsByCatalogId($catalogId): array
    {
        $sql = "SELECT * FROM `item` WHERE `catalog_id` = ? AND is_active = 1";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }
}
