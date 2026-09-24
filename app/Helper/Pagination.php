<?php

namespace App\Helper;

class Pagination
{


    public static function paginationCatalogType($catalogsType)
    {
        if (!in_array($catalogsType, ["lego", "shoe"], true)) {
            $catalogsType = "all";
        }
        return $catalogsType;
    }

    public static function paginationOrderBy($orderBy)
    {
        if (!in_array($orderBy, ["ASC", "DESC"], true)) {
            $orderBy = "ASC";
        }
        return $orderBy;
    }

    public static function paginationSortKey($sortKey)
    {
        if (!in_array($sortKey, ["type", "brand", "name", "price"], true)) {
            $sortKey = "all";
        }
        $sortColumns = [
            "all"   => "catalog.name",
            "type"  => "catalog.itemable_type",
            "brand" => "brand.name",
            "name"  => "catalog.name",
            "price" => "lowest_price",
        ];
        $sortDir = $sortColumns[$sortKey] ?? "catalog.name";
        return $sortDir;
    }

    public static function paginationLimit($pageLimit)
    {
        if (!filter_var($pageLimit, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 45]])) {
            $pageLimit = 15;
        }
        return $pageLimit;
    }

    public static function paginationPageNumber($pageNumber, $lastPage) {
        if (!filter_var($pageNumber, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => $lastPage]])) {
            $pageNumber = 1;
        }
        return $pageNumber;
    }
}
