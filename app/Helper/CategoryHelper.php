<?php

namespace App\Helper;

class CategoryHelper
{


    public static function isActive(): array
    {
        return [
            ["value" => "1", "text" => "Wahr"],
            ["value" => "0", "text" => "Falsch"],
        ];
    }

    public static function gender(): array
    {
        return [
            ["value" => "unisex", "text" => "Unisex"],
            ["value" => "men", "text" => "Männer"],
            ["value" => "women", "text" => "Frauen"],
        ];
    }
    public static function itemableTypes(): array
    {
        return [
            ["value" => "shoe", "text" => "Schuhe"],
            ["value" => "lego", "text" => "LEGO"],
        ];
    }
}
