<?php

namespace App\Helper;

class AppHelper
{
    public static function navClass($className, ...$expected)
    {
        if (in_array($className, $expected, true)) {
            return "active";
        }
        return "";
    }

    public static function priceShow(int $priceInCents): string
    {
        return number_format($priceInCents / 100, 2, ',', '.') . ' €';
    }
}
