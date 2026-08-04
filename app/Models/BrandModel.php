<?php

class BrandModel extends z_model
{

    public function getBrands(): array
    {
        $sql = "SELECT * FROM `brand` WHERE `active` = 1 ORDER BY `name` ASC";
        return $this->exec($sql)->resultToArray();
    }

    public function getBrandsAZ(): array
    {
        $sql = "SELECT UPPER(SUBSTRING(TRIM(name), 1, 1)) AS `firstLetter`, COUNT(*) AS amount FROM `brand` WHERE `active` = 1 GROUP BY `firstLetter` ORDER BY `firstLetter` ASC";
        return $this->exec($sql)->resultToArray();
    }

    public function getBrandsByFirstLetter($firstLetter): array
    {
        $sql = "SELECT * FROM `brand` WHERE `active` = 1 AND UPPER(SUBSTRING(TRIM(`name`), 1, 1)) = ? ORDER BY `name` ASC";
        return $this->exec($sql, "s", $firstLetter)->resultToArray();
    }


    public function getBrandsPlusInactive(): array
    {
        $sql = "SELECT * FROM `brand` WHERE `active` = 0 ORDER BY `name` ASC";
        return $this->exec($sql)->resultToArray();
    }

    public function getBrandById($brandId): array
    {
        $sql = "SELECT * FROM `brand` WHERE `id` = ?";
        return $this->exec($sql, "i", $brandId)->resultToLine();
    }

    public function deleteBrand($brandId)
    {
        $sql = "UPDATE `brand` SET `active` = 0 WHERE `id` = ?";
        $this->exec($sql, "i", $brandId);

        $log = "INSERT INTO `log_active` (`active_type`, `active_id`, `action`) VALUES ('brand', ?, 'gelöscht')";
        $this->exec($log, "i", $brandId);
    }
}
