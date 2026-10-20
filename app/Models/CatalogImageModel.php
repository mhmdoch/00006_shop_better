<?php

declare(strict_types=1);

class CatalogImageModel extends z_model
{
    public function getImagesByCatalogId(int $catalogId): array {
        $sql = "SELECT `catalog_image`.`id`, `z_file`.`id` AS `fileId`, `z_file`.`reference`, `z_file`.`extension`
                FROM `catalog_image`
                JOIN `z_file` ON `z_file`.`id` = `catalog_image`.`image`
                WHERE `catalog_image`.`catalog_id` = ?
                ORDER BY `catalog_image`.`id`";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    public function getImage(int $imageId, int $catalogId): ?array {
        $sql = "SELECT `catalog_image`.`id`, `z_file`.`id` AS `fileId`, `z_file`.`reference`, `z_file`.`extension`
                FROM `catalog_image`
                JOIN `z_file` ON `z_file`.`id` = `catalog_image`.`image`
                WHERE `catalog_image`.`id` = ? AND `catalog_image`.`catalog_id` = ?";
        return $this->exec($sql, "ii", $imageId, $catalogId)->resultToLine();
    }

    // Removing the file row also removes the catalog_image row (cascade)
    public function deleteFile(int $fileId): void {
        $this->exec("DELETE FROM `z_file` WHERE `id` = ?", "i", $fileId);
    }
}
