<?php

class ItemController extends z_controller
{

    public function action_itemshoecreate(Request $req, Response $res)
    {
        $req->checkPermission("item.create");

        $catalogId = $req->getParameters(0, 1);
        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("sku"))->required(),
                (new FormField("size"))->required(),
                (new FormField("color"))->required(),
                (new FormField("price"))->required(),
                (new FormField("stock"))->required()
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $itemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $catalogId]);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "item", "active_id" => $itemId, "action" => "aktiviert"]);

            return $res->success();
        }

        return $res->render("item/itemShoeCreate", [
            "catalog" => $catalog,
        ]);
    }

    public function action_itemShoeEdit(Request $req, Response $res)
    {
        $req->checkPermission("item.edit");

        $itemId = $req->getParameters(0, 1);
        $item = $req->getModel("Item")->getItemShoeById($itemId);
        $catalog = $req->getModel("Catalog")->getCatalogById($item["catalog_id"]);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("sku"))->required(),
                (new FormField("size"))->required(),
                (new FormField("color"))->required(),
                (new FormField("price"))->required(),
                (new FormField("stock"))->required()
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $newItemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $item["catalog_id"]]);
            $res->updateDatabase("item", "id", "i", $itemId, new FormResult(), ["active" => 0]);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "item", "active_id" => $newItemId, "action" => "aktiviert"]);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "item", "active_id" => $itemId, "action" => "deaktiviert"]);

            return $res->success();
        }

        App\Helper\Breadcrumbs::append("{$item['brand_name']} {$item['catalog_name']}", "/catalog/show/" . $item['catalog_id']);
        App\Helper\Breadcrumbs::append("Edit", "/catalog/show/" . $itemId);


        return $res->render("item/itemShoeEdit", [
            "item" => $item,
            "catalog" => $catalog,
        ]);
    }

    public function action_itemlegocreate(Request $req, Response $res)
    {
        $req->checkPermission("item.create");

        $catalogId = $req->getParameters(0, 1);
        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("sku"))->required(),
                (new FormField("name"))->required(),
                (new FormField("description"))->required(),
                (new FormField("set_number"))->required(),
                (new FormField("theme"))->required(),
                (new FormField("piece_count"))->required(),
                (new FormField("release_date"))->required(),
                (new FormField("price"))->required(),
                (new FormField("stock"))->required()
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $itemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $catalogId]);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "item", "active_id" => $itemId, "action" => "aktiviert"]);

            return $res->success();
        }

        return $res->render("item/itemLegoCreate", [
            "catalog" => $catalog,
        ]);
    }
}
