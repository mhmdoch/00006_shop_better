<?php

namespace App\Helper;

class AppHelper
{
    public static function price(string|int|float $amount): string
    {
        return number_format((float) $amount, 2, ',', '.') . ' €';
    }

    public static function priceShow(int $priceInCents): string
    {
        return number_format($priceInCents / 100, 2, ',', '.') . ' €';
    }
}
