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

    public static function orderPriceTaxes($cartItems): array
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

        $taxPot = [];
        foreach ($grossPot as $taxrate => $grossAmount) {
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
            'taxPot' => $taxPot,
            'totalSum' => $totalSum,
        ];
    }
}
