<?php

class CatalogModel extends z_model
{

    public function getCatalogs(): array
    {
        $sql = "SELECT catalog.*, brand.name AS brand_name FROM `catalog` JOIN `brand` ON catalog.brand_id = brand.id WHERE catalog.active = 1";
        return $this->exec($sql)->resultToArray();
    }

    public function getCatalogById($catalogId): array
    {
        $sql = "SELECT `catalog`.*, `brand`.`name` AS `brand_name` FROM `catalog` JOIN `brand` ON `catalog`.`brand_id` = `brand`.`id` WHERE `catalog`.`id` = ?";
        return $this->exec($sql, "i", $catalogId)->resultToLine();
    }

    public function getCatalogsByBrand($brandId): array
    {
        $sql = "SELECT * FROM `catalog` WHERE `brand_id` = ? ORDER BY `name`";
        return $this->exec($sql, "i", $brandId)->resultToArray();
    }
}
