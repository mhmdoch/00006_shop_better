<?php

namespace App\Helper;

class Breadcrumbs
{

    private static array $addedItems = [];

    public static function append(string $name, string $url): void
    {
        self::$addedItems[$name] = $url;
    }

    public static function items(): array
    {
        $items = [
            "Home" => "/",
        ];

        $urlParts = array_slice(request()->getUrlParts(), 0, 3);

        $currentUrl = "/";
        foreach ($urlParts as $part) {
            if (is_numeric($part)) break;

            $currentUrl .= $part . "/";
            $items[self::getNameByPath($part)] = $currentUrl;
        }

        return array_merge($items, self::$addedItems);
    }

    private static function getNameByPath(string $path): string
    {
        $path = strtolower($path);

        $translations = [
            "brand" => "Marken",
            "show" => "Details",
        ];

        return $translations[$path] ?? ucfirst($path);
    }
}
