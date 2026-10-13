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
        $sql = "SELECT *
                FROM `catalog_rating`
                WHERE `catalog_id` = ? AND `active` = 1
                ORDER BY `created` DESC, `id` DESC";
        return $this->exec($sql, "i", $catalogId)->resultToArray();
    }

    public function getRatingSummary($catalogId): array {
        $sql = "SELECT AVG(`stars`) AS average_stars, COUNT(*) AS rating_count
                FROM `catalog_rating`
                WHERE `catalog_id` = ? AND `active` = 1";
        $result = $this->exec($sql, "i", $catalogId)->resultToLine();
        $averageStars = $result["average_stars"] ?? null;

        return [
            "average_stars" => $averageStars === null ? null : (float) $averageStars,
            "rating_count" => (int) ($result["rating_count"] ?? 0),
        ];
    }

    public function deleteCatalogRating($ratingId): void {
        $sql = "UPDATE `catalog_rating` SET `active` = 0 WHERE `id` = ?";
        $this->exec($sql, "i", $ratingId);
    }
}
