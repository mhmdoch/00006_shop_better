<?php

class CatalogModel extends z_model
{

    public function getCatalogs(): array
    {
        $sql = "SELECT catalog.*, brand.name AS brand_name, MIN(i.`price`) AS lowest_price
                FROM `catalog`
                JOIN `brand` ON catalog.brand_id = brand.id
                LEFT JOIN `item` AS i ON i.`catalog_id` = catalog.id AND i.`active` = 1
                WHERE catalog.active = 1
                GROUP BY catalog.id";
        return $this->exec($sql)->resultToArray();
    }

    public function getCatalogById($catalogId): array
    {
        $sql = "SELECT `catalog`.*, `brand`.`name` AS `brand_name` FROM `catalog` JOIN `brand` ON `catalog`.`brand_id` = `brand`.`id` WHERE `catalog`.`id` = ?";
        return $this->exec($sql, "i", $catalogId)->resultToLine();
    }

    public function getCatalogsByFilters($type, $brandId, $name, $orderBy, $sortDir, $pageLimit, $pageOffset): array
    {
        $sql = "SELECT catalog.*, brand.name AS brand_name, MIN(i.`price`) AS lowest_price 
                            FROM `catalog` 
                            JOIN `brand` ON catalog.brand_id = brand.id 
                            LEFT JOIN `item` AS i ON i.`catalog_id` = `catalog`.id AND i.`active` = 1
                            WHERE catalog.active = 1 
                                    AND (? = 'all' OR catalog.itemable_type = ?) 
                                    AND (? = 0 OR catalog.brand_id = ?) 
                                    AND (? = 'all' OR CONCAT(brand.name, ' ', catalog.name) LIKE CONCAT('%', ?, '%')) 
                                    GROUP BY catalog.id 
                                    ORDER BY {$sortDir} {$orderBy}
                                    LIMIT ? OFFSET ?";
        return $this->exec($sql, "ssiissii", $type, $type, $brandId, $brandId, $name, $name, $pageLimit, $pageOffset)->resultToArray();
    }

    public function getCatalogsByFiltersAmount($type, $brandId, $name): int
    {
        $sql = "SELECT COUNT(*) AS amount
                FROM `catalog`
                JOIN `brand` ON catalog.brand_id = brand.id
                WHERE catalog.active = 1
                    AND (? = 'all' OR catalog.itemable_type = ?)
                    AND (? = 0 OR catalog.brand_id = ?)
                    AND (? = 'all' OR CONCAT(brand.name, ' ', catalog.name) LIKE CONCAT('%', ?, '%'))";

        $result = $this->exec($sql, "ssiiss", $type, $type, $brandId, $brandId, $name, $name)->resultToLine();

        return (int) ($result['amount'] ?? 0);
    }

    public function getCatalogsByBrand($brandId): array
    {
        $sql = "SELECT catalog.*, brand.name AS brand_name FROM `catalog` JOIN `brand` ON catalog.brand_id = brand.id WHERE `brand_id` = ? ORDER BY `name`";
        return $this->exec($sql, "i", $brandId)->resultToArray();
    }
}
