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

    public function action_show(Request $req, Response $res)
    {
        $catalogId = $req->getParameters(0, 1);

        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);
        $items = $req->getModel("Item")->getItemsByCatalogId($catalogId);

        return $res->render("catalog/show", [
            "catalog" => $catalog,
            "items" => $items
        ]);
    }
}
