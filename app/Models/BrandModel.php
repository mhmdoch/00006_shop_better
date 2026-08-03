<?php

class BrandModel extends z_model
{

    public function getBrands(): array
    {
        $sql = "SELECT * FROM `brand` WHERE `active` = 1 ORDER BY `name` ASC";
        return $this->exec($sql)->resultToArray();
    }


    public function getBrandById($brandId): array
    {
        $sql = "SELECT * FROM `brand` WHERE `id` = ?";
        return $this->exec($sql, "i", $brandId)->resultToLine();
    }


    public function deleteBrand($brandId)
    {
        $sql = "UPDATE `brand` SET `active` = false WHERE `id` = ?";
        $this->exec($sql, "i", $brandId);
    }
}
