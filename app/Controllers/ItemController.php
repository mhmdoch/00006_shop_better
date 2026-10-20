<?php

class ItemController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        if ($req->isAction("restore-item")) {
            $req->checkPermission("catalog.manage");
            return $this->restoreVersion($req, $res, (int) $req->getPost("itemId"));
        }

        return $res->reroute(["error", "404"]);
    }

    /**
     * Puts an old version of a variant back on sale. The version that is on sale now goes out of sale
     * and hands its stock over, so the stock does not jump back to an old value.
     */
    private function restoreVersion(Request $req, Response $res, int $itemId)
    {
        $items = $req->getModel("Item");
        $unavailable = "Diese Version kann nicht wiederhergestellt werden.";

        $item = $items->getItemShoeById($itemId);
        $currentId = $item === null || $item["active"] ? null : $items->getCurrentVersionId($itemId);
        if ($currentId === null) {
            return $res->error($unavailable);
        }

        $current = $items->getItemShoeById($currentId);
        if (!$items->deactivateItem($currentId, (int) $current["stock"])) {
            return $res->error("Die Variante wurde zwischenzeitlich geändert. Bitte die Seite neu laden.");
        }

        $restored = false;
        try {
            $restored = $items->activateReplaced($itemId, (int) $current["stock"]);
            if (!$restored) {
                $items->setActive($currentId, true);
                return $res->error($unavailable);
            }

            $items->setReplacedBy($currentId, $itemId);
            $res->getModel("Order")->deleteLostCartItems($currentId);
        } catch (\Throwable $e) {
            // Back to the version that was on sale
            if ($restored) {
                $items->setActive($itemId, false);
                $items->setReplacedBy($itemId, $item["replaced_by"] === null ? null : (int) $item["replaced_by"]);
                $items->setStock($itemId, (int) $item["stock"]);
            }
            $items->setReplacedBy($currentId, null);
            $items->setActive($currentId, true);
            throw $e;
        }

        $res->insertDatabase("log_active", new FormResult(),
            ["active_type" => "item", "active_id" => $itemId, "action" => "aktiviert", "userId" => user()->userId]);
        $res->insertDatabase("log_active", new FormResult(),
            ["active_type" => "item", "active_id" => $currentId, "action" => "deaktiviert", "userId" => user()->userId]);

        return $res->success();
    }

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

            return $this->saveItemVersion($req, $res, $item, $formResult, ["sku", "size", "color", "taxrate", "price"]);
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
                $req, $res, $item, $formResult,
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
    private function saveItemVersion(Request $req, Response $res, array $item, FormResult $formResult, array $fields, array $extra = [])
    {
        $itemId = $item["id"];
        $itemChanges = [];

        // Orders change the stock too. If it is not what the admin saw, saving would overwrite them.
        $stockBefore = $req->getPost("stock_before");
        if (!is_numeric($stockBefore) || (int) $stockBefore !== (int) $item["stock"]) {
            return $res->error("Der Bestand wurde zwischenzeitlich geändert. Bitte die Seite neu laden.");
        }

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
            // Only writes if nobody changed the stock since the check above
            $stockChanged = $req->getModel("Item")->changeStock((int) $itemId, (int) $oldStock, (int) $newStock);
            if (!$stockChanged) {
                return $res->error("Der Bestand wurde zwischenzeitlich geändert. Bitte die Seite neu laden.");
            }

            $action = $newStock > $oldStock ? "stock erhöht" : "stock reduziert";
            $res->insertDatabase("log_active",
                                    new FormResult(),
                                    ["active_type" => "item", "active_id" => $itemId, "action" => $action, "userId" => user()->userId]);

            return $res->success();
        }

        // The old version is taken out of sale first, and only if it is still the one the admin saw.
        // This also keeps an old, already replaced version from getting a new version of its own.
        if (!$req->getModel("Item")->deactivateItem((int) $itemId, (int) $oldStock)) {
            return $res->error("Diese Variante wurde zwischenzeitlich geändert. Bitte die Seite neu laden.");
        }

        $newItemId = null;
        try {
            $newItemId = $res->insertDatabase("item", $formResult, ["catalog_id" => $item["catalog_id"]] + $extra);
            $req->getModel("Item")->setReplacedBy((int) $itemId, (int) $newItemId);
            $res->getModel("Order")->deleteLostCartItems($itemId);
        } catch (\Throwable $e) {
            // Back to the old version, so there is never no or a second active version
            if ($newItemId !== null) $req->getModel("Item")->setActive((int) $newItemId, false);
            $req->getModel("Item")->setReplacedBy((int) $itemId, null);
            $req->getModel("Item")->setActive((int) $itemId, true);
            throw $e;
        }

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
