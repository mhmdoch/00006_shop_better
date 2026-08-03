<?php

class BrandController extends z_controller
{

    public function action_index(Request $req, Response $res)
    {
        $brands = $req->getModel("Brand")->getBrands();

        return $res->render("brand/index", [
            "brands" => $brands,
        ]);
    }



    public function action_show(Request $req, Response $res)
    {
        $brandId = $req->getParameters(0, 1);

        $brand = $req->getModel("Brand")->getBrandById($brandId);
        $catalogs = $req->getModel("Catalog")->getCatalogsByBrand($brandId);

        $catalogIds = array_column($catalogs, "id");
        $items = $req->getModel("Item")->getItemsByCatalogIds($catalogIds);

        return $res->render("brand/show", [
            "brand" => $brand,
            "catalogs" => $catalogs,
            "items" => $items,
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

            $res->insertDatabase("brand", $formResult);

            return $res->success();
        }

        return $res->render("brand/create", [
            //"userId" => $user->userId,
        ]);
    }
}
