<?php

class DiscountModel extends z_model
{
    public function getDiscounts(): array {
        $sql = "SELECT * FROM `discount` ORDER BY `active` DESC, `code` ASC";
        return $this->exec($sql)->resultToArray();
    }

    public function getDiscountById($discountId): ?array {
        $sql = "SELECT *
                FROM `discount`
                WHERE `id` = ?";
        return $this->exec($sql, "i", $discountId)->resultToLine();
    }

    public function deleteDiscount($discountId): void {
        $sql = "UPDATE `discount` SET `active` = 0 WHERE `id` = ?";
        $this->exec($sql, "i", $discountId);
    }

    public function getDiscountByCode(string $code): ?array {
        $sql = "SELECT * FROM `discount` WHERE `code` = ? LIMIT 1";
        return $this->exec($sql, "s", $code)->resultToLine();
    }

    public function getDiscountError(?array $discount, string $subtotal): ?string {
        if ($discount === null || !$discount["active"]) {
            return "Dieser Rabattcode ist ungültig oder nicht mehr aktiv.";
        }

        if (bccomp($subtotal, $discount["min_total"], 2) < 0) {
            return "Der Mindestbestellwert für diesen Rabattcode beträgt "
                . number_format((float) $discount["min_total"], 2, ",", ".") . " €.";
        }

        return null;
    }
}
