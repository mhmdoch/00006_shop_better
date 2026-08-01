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
}
