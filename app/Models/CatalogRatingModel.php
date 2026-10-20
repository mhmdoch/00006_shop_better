<?php

class CatalogRatingModel extends z_model
{
    public function getRatingById($ratingId): ?array {
        $sql = "SELECT *
                FROM `catalog_rating`
                WHERE `id` = ?";
        return $this->exec($sql, "i", $ratingId)->resultToLine();
    }

    public function getRatingByUser($catalogId, $userId): ?array {
        $sql = "SELECT *
                FROM `catalog_rating`
                WHERE `catalog_id` = ? AND `user_id` = ?";
        return $this->exec($sql, "ii", $catalogId, $userId)->resultToLine();
    }

    public function getRatingsByCatalogId($catalogId): array {
        $sql = "SELECT `catalog_rating`.*, `z_file`.`reference` AS `photo_reference`
                FROM `catalog_rating`
                LEFT JOIN `z_file` ON `z_file`.`id` = `catalog_rating`.`photo`
                WHERE `catalog_rating`.`catalog_id` = ? AND `catalog_rating`.`active` = 1
                ORDER BY `catalog_rating`.`created` DESC, `catalog_rating`.`id` DESC";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    public function getRatingPhoto($ratingId): ?array {
        $sql = "SELECT `z_file`.`id` AS `fileId`, `z_file`.`reference`, `z_file`.`extension`
                FROM `catalog_rating`
                JOIN `z_file` ON `z_file`.`id` = `catalog_rating`.`photo`
                WHERE `catalog_rating`.`id` = ?";
        return $this->exec($sql, "i", $ratingId)->resultToLine();
    }

    // Used when the uploaded photo turns out not to be a usable image
    public function removeRatingWithPhoto($ratingId, ?int $fileId): void {
        $this->exec("DELETE FROM `catalog_rating` WHERE `id` = ?", "i", $ratingId);

        if ($fileId !== null) {
            $this->exec("DELETE FROM `z_file` WHERE `id` = ?", "i", $fileId);
        }
    }

    public function getRatingSummary($catalogId): array {
        $sql = "SELECT AVG(`stars`) AS average_stars, COUNT(*) AS rating_count
                FROM `catalog_rating`
                WHERE `catalog_id` = ? AND `active` = 1";
        $result = $this->exec($sql, "i", $catalogId)->resultToLine();
        $averageStars = $result["average_stars"] ?? null;

        return [
            "average_stars" => $averageStars === null ? null : (string) $averageStars,
            "rating_count" => (int) ($result["rating_count"] ?? 0),
        ];
    }

    public function deleteCatalogRating($ratingId): void {
        $sql = "UPDATE `catalog_rating` SET `active` = 0 WHERE `id` = ?";
        $this->exec($sql, "i", $ratingId);
    }
}
