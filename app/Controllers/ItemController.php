<?php

class ItemController extends z_controller
{

    public function action_itemshoecreate(Request $req, Response $res)
    {
        $req->checkPermission("catalog.manage");

        $catalogId = $req->getParameters(0, 1);
        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);

        if ($catalog === null) {
            return $res->reroute(["error", "404"]);
        }

        if ($req->hasFormData()) {
            $formResult = $req->validateForm($this->shoeFormFields());

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $this->taxrateToFraction($formResult);

             $itemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $catalogId]);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "item", "active_id" => $itemId, "action" => "aktiviert", "userId" => user()->userId]);

            return $res->success();
        }

        return $res->render("item/itemShoeCreate", [
            "catalog" => $catalog,
            "navMenu" => "item",
        ]);
    }

    public function action_itemShoeEdit(Request $req, Response $res)
    {
        $req->checkPermission("catalog.manage");

        $itemId = $req->getParameters(0, 1);
        $item = $req->getModel("Item")->getItemShoeById($itemId);

        if ($item === null) {
            return $res->reroute(["error", "404"]);
        }

        $catalog = $req->getModel("Catalog")->getCatalogById($item["catalog_id"]);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm($this->shoeFormFields());

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $this->taxrateToFraction($formResult);

            return $this->saveItemVersion($res, $item, $formResult, ["sku", "size", "color", "taxrate", "price"]);
        }

        App\Helper\Breadcrumbs::append("{$item['brand_name']} {$item['catalog_name']}", "/catalog/show/" . $item['catalog_id']);
        App\Helper\Breadcrumbs::append("Edit", "/catalog/show/" . $itemId);


        return $res->render("item/itemShoeEdit", [
            "item" => $item,
            "catalog" => $catalog,
            "navMenu" => "item",
        ]);
    }

    public function action_itemLegoEdit(Request $req, Response $res)
    {
        $req->checkPermission("catalog.manage");

        $itemId = $req->getParameters(0, 1);
        $item = $req->getModel("Item")->getItemShoeById($itemId);

        if ($item === null) {
            return $res->reroute(["error", "404"]);
        }

        $catalog = $req->getModel("Catalog")->getCatalogById($item["catalog_id"]);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm($this->legoFormFields());

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            return $this->saveItemVersion(
                $res, $item, $formResult,
                ["sku", "name", "description", "set_number", "theme", "piece_count", "release_date", "price"],
                ["taxrate" => $item["taxrate"]]
            );
        }

        App\Helper\Breadcrumbs::append("{$item['brand_name']} {$item['catalog_name']}", "/catalog/show/" . $item['catalog_id']);
        App\Helper\Breadcrumbs::append("Edit", "/catalog/show/" . $itemId);

        return $res->render("item/itemLegoEdit", [
            "item" => $item,
            "catalog" => $catalog,
            "navMenu" => "item",
        ]);
    }

    /**
     * Only a stock change updates the item in place. Any other change creates
     * a new version of the item and deactivates the old one.
     */
    private function saveItemVersion(Response $res, array $item, FormResult $formResult, array $fields, array $extra = [])
    {
        $itemId = $item["id"];
        $itemChanges = [];

        foreach ($fields as $field) {
            $newValue = $formResult->getValue($field);
            $oldValue = $item[$field];

            if ($newValue != $oldValue) {
                $itemChanges[$field] = [
                    "old" => $oldValue,
                    "new" => $newValue
                ];
            }
        }

        $newStock = $formResult->getValue("stock");
        $oldStock = $item["stock"];

        // Nothing changed, keep the current variant
        if (empty($itemChanges) && $newStock == $oldStock) {
            return $res->success();
        }

        if (empty($itemChanges)) {
            $res->updateDatabase("item", "id", "i", $itemId, new FormResult(), ["stock" => $newStock]);

            $action = $newStock > $oldStock ? "stock erhöht" : "stock reduziert";
            $res->insertDatabase("log_active",
                                    new FormResult(),
                                    ["active_type" => "item", "active_id" => $itemId, "action" => $action, "userId" => user()->userId]);

            return $res->success();
        }

        $newItemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $item["catalog_id"]] + $extra);
        $res->updateDatabase(
                        "item", "id",
                        "i",
                        $itemId, new FormResult(), ["active" => 0]);

        $res->getModel("Order")->deleteLostCartItems($itemId);

        $res->insertDatabase("log_active",
                                new FormResult(),
                                ["active_type" => "item", "active_id" => $newItemId, "action" => "aktiviert", "userId" => user()->userId]);
        $res->insertDatabase("log_active",
                                new FormResult(),
                                ["active_type" => "item", "active_id" => $itemId, "action" => "deaktiviert", "userId" => user()->userId]);

        return $res->success();
    }

    public function action_itemlegocreate(Request $req, Response $res)
    {
        $req->checkPermission("catalog.manage");

        $catalogId = $req->getParameters(0, 1);
        $catalog = $req->getModel("Catalog")->getCatalogById($catalogId);

        if ($catalog === null) {
            return $res->reroute(["error", "404"]);
        }

        if ($req->hasFormData()) {
            $formResult = $req->validateForm($this->legoFormFields());

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $itemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $catalogId]);
            $res->insertDatabase("log_active",
                                    new FormResult(),
                                    ["active_type" => "item", "active_id" => $itemId, "action" => "aktiviert", "userId" => user()->userId]);

            return $res->success();
        }

        return $res->render("item/itemLegoCreate", [
            "catalog" => $catalog,
            "navMenu" => "item",
        ]);
    }

    /**
     * The form takes the tax rate in percent (19), the database stores it as a fraction (0.19).
     */
    private function taxrateToFraction(FormResult $formResult): void
    {
        foreach ($formResult->fields as $field) {
            if ($field->name === "taxrate") {
                $field->value = bcdiv($field->value, "100", 2);
            }
        }
    }

    private function shoeFormFields(): array
    {
        return [
            (new FormField("sku"))->required()->length(1, 100),
            (new FormField("size"))->required()->length(1, 100),
            (new FormField("color"))->required()->length(1, 255),
            (new FormField("taxrate"))->required()->regex('/^\d{1,3}$/')->range(0, 100),
            $this->priceField(),
            $this->stockField(),
        ];
    }

    private function legoFormFields(): array
    {
        return [
            (new FormField("sku"))->required()->length(1, 100),
            (new FormField("name"))->required()->length(1, 255),
            (new FormField("description"))->required(),
            (new FormField("set_number"))->required()->length(1, 30),
            (new FormField("theme"))->required()->length(1, 100),
            (new FormField("piece_count"))->required()->integer()->range(1, 100000),
            (new FormField("release_date"))->required()->date(),
            $this->priceField(),
            $this->stockField(),
        ];
    }

    private function priceField(): FormField
    {
        return (new FormField("price"))->required()
            ->regex('/^\d{1,10}(\.\d{1,2})?$/')
            ->range(0.01, 9999999999.99);
    }

    private function stockField(): FormField
    {
        return (new FormField("stock"))->required()->integer()->range(0, 1000000);
    }
}
