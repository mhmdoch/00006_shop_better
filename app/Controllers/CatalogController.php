<?php

class CatalogController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        $catalogs = $req->getModel("Catalog")->getCatalogs();

        return $res->render("catalog/index", [
            "catalogs" => $catalogs,
        ]);
    }

    public function action_paginate(Request $req, Response $res)
    {

        $catalogsType = $req->getParameters(0, 1) ?: "all";
        $brandId = $req->getParameters(1, 1) ?: 0;
        $name = $req->getParameters(2, 1) ?: "all";

        $sortDir = $req->getParameters(3, 1) ?: "name";

        // catalog/paginate/all/0/all/name/ASC/10/0
        // type: all, shoe, lego

        $orderBy = $req->getParameters(4, 1) ?: "ASC";
        if (!in_array($orderBy, ["ASC", "DESC"], true)) {
            $orderBy = "ASC";
        }
        $pageLimit = $req->getParameters(5, 1) ?: 24;
        $pageOffset = $req->getParameters(6, 1) ?: 0;


        $catalogs = $req->getModel("Catalog")->getCatalogsByFilters($catalogsType, $brandId, $name, $orderBy, $sortDir, $pageLimit, $pageOffset);

        return $res->render("catalog/index", [
            "catalogs" => $catalogs,
        ]);
    }

    public function action_show(Request $req, Response $res)
    {
        $catalogId = $req->getParameters(0, 1);

        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);
        $items = $req->getModel("Item")->getItemsByCatalogId($catalogId);

        return $res->render("catalog/show", [
            "catalog" => $catalog,
            "items" => $items,
        ]);
    }
}
