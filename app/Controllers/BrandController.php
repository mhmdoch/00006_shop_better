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
        // if ($req->hasFormData()) {
        //     $formResult = $req->validateForm([
        //         // (new FormField("title"))->required()->length(3, 255),
        //         // (new FormField("subtitle"))->length(0, 500),
        //         // (new FormField("language"))->required()->length(2, 2),
        //         // (new FormField("content"))->required()->length(5, 10000),
        //         // (new FormField("is_published"))
        //     ]);

        //     if ($formResult->hasErrors) {
        //         return $res->formErrors($formResult->errors);
        //     }


        //     $isPublished = $req->getPost("is_published");
        //     $fixed = [
        //         "z_user_id" => $user->userId,
        //     ];

        //     if ($isPublished) {

        //         $publishedAtDate = date("Y-m-d H:i:s");

        //         $fixed["published_at"] = $publishedAtDate;
        //         $res->insertDatabase("post", $formResult, $fixed);

        //         model("Queue")->publishToAll(
        //             "postalert",
        //             "1",
        //             [
        //                 "title" => $req->getPost("title"),
        //                 "subtitle" => $req->getPost("subtitle"),
        //                 "published_at" => $publishedAtDate,
        //                 "content" => $req->getPost("content"),
        //                 "email" => $user->fields["email"],
        //             ],
        //         );
        //     } else {
        //         $res->insertDatabase("post", $formResult, $fixed);
        //     }



        //     return $res->success();
        // }
        return $res->render("brand/create", [
            //"userId" => $user->userId,
        ]);
    }
}
