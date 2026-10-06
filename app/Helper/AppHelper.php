<?php

namespace App\Helper;

class AppHelper
{
    public static function priceShow(int $priceInCents): string
    {
        return number_format($priceInCents / 100, 2, ',', '.') . ' €';
    }
}
