<?php

class BrandController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        $brands = $req->getModel("Brand")->getBrands();

        $showActivity = false;

        $brandsAZ = $req->getModel("Brand")->getBrandsAZ();

        if ($req->isAction("delete-brand")) {
            $req->checkPermission("brand.delete");
            $brandId = $req->getPost("brandId");
            $req->getModel("Brand")->deleteBrand($brandId);
            return $res->success();
        }

        return $res->render("brand/index", [
            "brands" => $brands,
            "showActivity" => $showActivity,
            "brandsAZ" => $brandsAZ
        ]);
    }

    public function action_az(Request $req, Response $res)
    {
        $firstLetter = $req->getParameters(0, 1);

        $brands = $req->getModel("Brand")->getBrandsByFirstLetter($firstLetter);

        $showActivity = false;

        $brandsAZ = $req->getModel("Brand")->getBrandsAZ();

        if ($req->isAction("delete-brand")) {
            $req->checkPermission("brand.delete");
            $brandId = $req->getPost("brandId");
            $req->getModel("Brand")->deleteBrand($brandId);
            return $res->success();
        }

        return $res->render("brand/index", [
            "brands" => $brands,
            "showActivity" => $showActivity,
            "brandsAZ" => $brandsAZ
        ]);
    }

    public function action_inactive(Request $req, Response $res)
    {
        $req->checkPermission("brand.create");

        $brands = $req->getModel("Brand")->getBrandsPlusInactive();

        $showActivity = true;

        $brandsAZ = $req->getModel("Brand")->getBrandsAZ();


        if ($req->isAction("delete-brand")) {
            $req->checkPermission("brand.delete");
            $brandId = $req->getPost("brandId");
            $req->getModel("Brand")->deleteBrand($brandId);
            return $res->success();
        }

        return $res->render("brand/index", [
            "brands" => $brands,
            "showActivity" => $showActivity,
            "brandsAZ" => $brandsAZ
        ]);
    }

    public function action_show(Request $req, Response $res)
    {
        $brandId = $req->getParameters(0, 1);

        $brand = $req->getModel("Brand")->getBrandById($brandId);
        $catalogs = $req->getModel("Catalog")->getCatalogsByBrand($brandId);

        $catalogIds = array_column($catalogs, "id");
        $items = $req->getModel("Item")->getItemsByCatalogIds($catalogIds);
        $logActive = $req->getModel("LogActive")->getLogByidAndType($brandId, "brand");

        App\Helper\Breadcrumbs::append("Reebok", "/test");

        return $res->render("brand/show", [
            "brand" => $brand,
            "catalogs" => $catalogs,
            "items" => $items,
            "logActive" => $logActive,
        ]);
    }

    public function action_create(Request $req, Response $res)
    {
        $req->checkPermission("brand.create");

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("name"))->required()->length(3, 255),
                (new FormField("website"))->length(5, 500)
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $brandId = $res->insertDatabase("brand", $formResult);
            $res->insertDatabase("log_active", new FormResult(), ["active_type" => "brand", "active_id" => $brandId, "action" => "aktiviert"]);


            return $res->success();
        }

        return $res->render("brand/create", [
            //"userId" => $user->userId,
        ]);
    }

    public function action_edit(Request $req, Response $res)
    {
        $req->checkPermission("brand.edit");

        $brandId = $req->getParameters(0, 1);
        $brand = $req->getModel("Brand")->getBrandById($brandId);

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("name"))->required()->length(3, 255),
                (new FormField("website"))->length(5, 500)
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $res->updateDatabase("brand", "id", "i", $brandId, $formResult);
            return $res->success();
        }

        return $res->render("brand/edit", [
            "brand" => $brand,
        ]);
    }
}
