<?php

namespace App\Helper;

class OrderState
{

    public function orderStateNext($orderState): array
    {
        return match ($orderState) {
            "pending"   => ["confirmed", "cancelled"],
            "confirmed" => ["paid", "cancelled"],
            "paid"      => ["shipped", "cancelled"],
            "shipped"   => ["completed"],
            "completed", "cancelled" => [],

        };
    }

    public static function getDiscountAmount(array $discount, string $subtotal): string
    {
        $amount = $discount["value"];

        if ($discount["type"] === "percent") {
            $amount = bcdiv(bcmul($subtotal, $discount["value"], 4), '100', 4);
        }

        $amount = bcadd($amount, '0.005', 2);
        return bccomp($amount, $subtotal, 2) > 0 ? $subtotal : $amount;
    }

    public static function orderPriceTaxes($cartItems, ?array $discount = null): array
    {
        $grossPot = [];
        $totalSum = '0.00';

        foreach ($cartItems as $cartItem) {
            $taxrate = $cartItem["taxrate"];
            $grossPrice = $cartItem["price"];
            $quantity = $cartItem["quantity"];

            $cartItemFullPrice = bcmul($grossPrice, $quantity, 2);
            $totalSum = bcadd($totalSum, $cartItemFullPrice, 2);


            if (!isset($grossPot[$taxrate])) {
                $grossPot[$taxrate] = '0.00';
            }

            $grossPot[$taxrate] = bcadd($grossPot[$taxrate], $cartItemFullPrice, 2);
        }

        $subtotal = $totalSum;
        $discountAmount = $discount === null ? '0.00' : self::getDiscountAmount($discount, $subtotal);
        $totalSum = bcsub($subtotal, $discountAmount, 2);

        $remainingGross = $subtotal;
        $remainingDiscount = $discountAmount;
        $taxPot = [];
        foreach ($grossPot as $taxrate => $grossAmount) {
            $groupDiscount = '0.00';
            if (bccomp($remainingGross, '0.00', 2) > 0) {
                $groupDiscount = bcdiv(bcmul($remainingDiscount, $grossAmount, 4), $remainingGross, 2);
            }

            $remainingGross = bcsub($remainingGross, $grossAmount, 2);
            $remainingDiscount = bcsub($remainingDiscount, $groupDiscount, 2);
            $grossAmount = bcsub($grossAmount, $groupDiscount, 2);
            $netAmount = bcdiv($grossAmount, bcadd('1', $taxrate, 2), 2);
            $taxAmount = bcsub($grossAmount, $netAmount, 2);
            $taxPot[$taxrate] = [
                'gross' => $grossAmount,
                'net' => $netAmount,
                'tax' => $taxAmount,
                'taxrate' => $taxrate,
            ];
        }

        return [
            'subtotal' => $subtotal,
            'discountAmount' => $discountAmount,
            'discountCode' => $discount['code'] ?? null,
            'taxPot' => $taxPot,
            'totalSum' => $totalSum,
        ];
    }
}
