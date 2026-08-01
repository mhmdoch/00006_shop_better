<?php

class CatalogModel extends z_model
{

    public function getCatalogsIfActive(): array
    {
        $sql = "SELECT * FROM `catalog` WHERE is_active = 1";
        return $this->exec($sql)->resultToArray();
    }

    public function getCatalogById($catalogId): array
    {
        $sql = "SELECT * FROM `catalog` WHERE `id` = ?";
        return $this->exec($sql, "i", $catalogId)->resultToLine();
    }
}
