<?php

use \App\Helper\Pagination;
use \App\Helper\CategoryHelper;
use \App\Helper\Thumbnail;

class CatalogController extends z_controller
{

    public function action_create(Request $req, Response $res)
    {
        $req->checkPermission("catalog.create");

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("brand_id"))->required()->length(1, 255),
                (new FormField("name"))->required(),
                (new FormField("itemable_type"))->required(),
                (new FormField("description"))->required()->length(5, 500),
                (new FormField("gender"))->length(1, 100),
                (new FormField("titlethumb"))->file(
                    FILE_SIZE_20MB,
                    ["jpg", "jpeg", "png"]
                ),
                (new FormField("active"))->length(1, 500),
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $catalogId = $res->insertDatabase("catalog", $formResult);

            $titlethumb = $req->getModel("Catalog")->getCatalogPictureByCatalogId($catalogId);

            $imageAsJPG = new Thumbnail();
            $imageAsJPG = $imageAsJPG->toJPGwithThumb($titlethumb["reference"], $titlethumb["extension"], $titlethumb["thumbid"], $req);
            



            $res->insertDatabase(
                            "log_active",
                            new FormResult(),
                            [
                            "userId" => user()->userId,
                            "active_type" => "catalog",
                            "active_id" => $catalogId,
                            "action" => "aktiviert"]
                            );

            return $res->success();
        }

        $brands = $req->getModel("Brand")->getBrands();

        return $res->render("catalog/create", [
            "brands" => $brands,
            "itemableTypes" => CategoryHelper::itemableTypes(),
            "isActive" => CategoryHelper::isActive(),
            "genders" => CategoryHelper::gender(),
        ]);
    }


    public function action_edit(Request $req, Response $res)
    {
        $req->checkPermission("catalog.edit");

        $catalogId = $req->getParameters(0, 1);
        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);

        if ($req->hasFormData()) {
                    $formResult = $req->validateForm([
                        (new FormField("brand_id"))->required()->length(1, 255),
                        (new FormField("name"))->required(),
                        (new FormField("itemable_type"))->required(),
                        (new FormField("description"))->required()->length(5, 500),
                        (new FormField("gender"))->length(1, 100),
                        (new FormField("titlethumb"))->file(
                            FILE_SIZE_20MB,
                            ["jpg", "jpeg", "png"]
                        ),
                        (new FormField("active"))->length(1, 500),
                    ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $res->updateDatabase("catalog", "id", "i", $catalogId, $formResult);
            return $res->success();
        }

        $brands = $req->getModel("Brand")->getBrands();

        return $res->render("catalog/edit", [
            "brands" => $brands,
            "catalog" => $catalog,
            "itemableTypes" => CategoryHelper::itemableTypes(),
            "isActive" => CategoryHelper::isActive(),
            "genders" => CategoryHelper::gender(),
        ]);
    }



    public function action_index(Request $req, Response $res)
    {
        $catalogsType = $req->getParameters(0, 1);
        $catalogsType =  Pagination::paginationCatalogType($catalogsType);

        $brandId = $req->getParameters(1, 1) ?: 0;
        $name = $req->getParameters(2, 1) ?: "all";

        $sortKey = $req->getParameters(3, 1);
        $sortDir =  Pagination::paginationSortKey($sortKey);
    
        $orderBy = $req->getParameters(4, 1);
        $orderBy = Pagination::paginationOrderBy($orderBy);

        $pageLimit = $req->getParameters(5, 1);
        $pageLimit = Pagination::paginationLimit($pageLimit);


        $pageNumber = $req->getParameters(6, 1);
        $catalogsAmount = $req->getModel("Catalog")->getCatalogsByFiltersAmount(
                                                                            $catalogsType, 
                                                                            $brandId, 
                                                                            $name
                                                                            );
        $pagination['pageLast'] = max(1, (int) ceil($catalogsAmount / $pageLimit));
        $pageNumber = Pagination::paginationPageNumber($pageNumber, $pagination['pageLast']);

        $brands = $req->getModel("Brand")->getBrands();

        $pageOffset = (int) $pageLimit * ($pageNumber - 1);

        $catalogs = $req->getModel("Catalog")->getCatalogsByFilters(
            $catalogsType,
            $brandId,
            $name, $orderBy, $sortDir, $pageLimit, $pageOffset
            );

        $settings['type'] = $catalogsType;
        $settings['brandId'] = $brandId;
        $settings['name'] = $name;
        $settings['limit'] = $pageLimit;
        $settings['orderBy'] = $orderBy;
        $settings['sortKey'] = $sortKey;

        $pagination['pageCurrent'] = $pageNumber;

        $settings['pageNeighboorsAmount'] = 3;

        $pagesAvailableLeft = $pageNumber - 1;
        $pagesAvailableRight = $pagination['pageLast'] - $pageNumber;

        $pagination['pageNeighboorsLeft'] = ($pagesAvailableLeft >= $settings['pageNeighboorsAmount']) ?
                                                $settings['pageNeighboorsAmount'] : $pagesAvailableLeft;
        $pagination['pageNeighboorsRight'] = ($pagesAvailableRight >= $settings['pageNeighboorsAmount']) ?
                                                $settings['pageNeighboorsAmount'] : $pagesAvailableRight;



        return $res->render("catalog/index", [
            "catalogs" => $catalogs,
            "brands" => $brands,
            "settings" => $settings,
            "pagination" => $pagination
        ]);
    }

    public function action_show(Request $req, Response $res)
    {

        $catalogId = $req->getParameters(0, 1);

        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);
        $items = $req->getModel("Item")->getItemsByCatalogId($catalogId);

        $titlethumb = $req->getModel("Catalog")->getCatalogPictureByCatalogId($catalogId);

   

  
        $sizes = [];
        $colors = [];
        $currentSize = "all";
        $currentColor = "all";
        $selectedItem = null;

        if ($catalog["itemable_type"] === "shoe") {
            $sizes = array_values(array_unique(array_column($items, "size")));
            sort($sizes, SORT_NATURAL);

            $currentSize = $req->getGet("size", "all");
            if ($currentSize !== "all" && !in_array($currentSize, $sizes, true)) {
                $currentSize = "all";
            }

            $itemsForColors = array_filter($items, function ($item) use ($currentSize) {
                return $currentSize === "all" || $item["size"] === $currentSize;
            });

            $colors = array_values(array_unique(array_column($itemsForColors, "color")));
            sort($colors, SORT_NATURAL);

            $currentColor = $req->getGet("color", "all");
            if ($currentSize === "all" || !in_array($currentColor, $colors, true)) {
                $currentColor = "all";
            }

            if ($currentColor !== "all") {
                $selectedItems = array_values(array_filter($itemsForColors, function ($item) use ($currentColor) {
                    return $item["color"] === $currentColor;
                }));

                if (count($selectedItems) === 1) {
                    $selectedItem = $selectedItems[0];
                }
            }
        }

        App\Helper\Breadcrumbs::append("{$catalog['brand_name']} {$catalog['name']}", "/catalog/show/" . $catalogId);

        return $res->render("catalog/show", [
            "catalog" => $catalog,
            "items" => $items,
            "sizes" => $sizes,
            "colors" => $colors,
            "currentSize" => $currentSize,
            "currentColor" => $currentColor,
            "selectedItem" => $selectedItem,
            "titlethumb" => $titlethumb,
        ]);
    }
}
