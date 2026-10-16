<?php

class DiscountController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $req->checkPermission("discount.manage");

        if ($req->isAction("delete-discount")) {
            $discountId = $req->getPost("discountId");
            $req->getModel("Discount")->deleteDiscount($discountId);
            return $res->success();
        }

        $discounts = $req->getModel("Discount")->getDiscounts();

        return $res->render("discount/index", [
            "discounts" => $discounts,
            "navMenu" => "discount",
        ]);
    }

    public function action_show(Request $req, Response $res)
    {
        $req->checkPermission("discount.manage");

        $discountId = $req->getParameters(0, 1);
        $discount = $req->getModel("Discount")->getDiscountById($discountId);

        if ($discount === null) {
            return $res->reroute(["error", "404"]);
        }

        App\Helper\Breadcrumbs::append($discount["code"], "/discount/show/" . $discountId);

        return $res->render("discount/show", [
            "discount" => $discount,
            "navMenu" => "discount",
        ]);
    }

    public function action_create(Request $req, Response $res)
    {
        $req->checkPermission("discount.manage");

        if ($req->hasFormData()) {
            $formResult = $this->validateDiscountForm($req);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $res->insertDatabase("discount", $formResult);
            return $res->success();
        }

        return $res->render("discount/create", [
            "navMenu" => "discount",
        ]);
    }

    public function action_edit(Request $req, Response $res)
    {
        $req->checkPermission("discount.manage");

        $discountId = $req->getParameters(0, 1);
        $discount = $req->getModel("Discount")->getDiscountById($discountId);

        if ($discount === null) {
            return $res->reroute(["error", "404"]);
        }

        if ($req->hasFormData()) {
            $formResult = $req->validateForm([
                (new FormField("active"))->required()->integer()->in([0, 1]),
            ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $res->updateDatabase("discount", "id", "i", $discountId, $formResult);
            return $res->success();
        }

        return $res->render("discount/edit", [
            "discount" => $discount,
            "navMenu" => "discount",
        ]);
    }

    private function validateDiscountForm(Request $req): FormResult
    {
        $formData = $req->getPost();

        if (($formData["min_total"] ?? null) === "0") {
            $formData["min_total"] = "0.00";
        }

        return $req->validateForm($this->discountFormFields($req->getPost("type")), $formData);
    }

    private function discountFormFields($type): array
    {
        return [
            (new FormField("code"))->required()->length(1, 100)
                ->unique("discount", "code"),
            (new FormField("type"))->required()->in(["percent", "fixed"]),
            (new FormField("value"))->required()->regex('/^\d{1,10}(\.\d{1,2})?$/')
                ->range(0.01, $type === "percent" ? 100 : 9999999999.99),
            (new FormField("active"))->required()->integer()->in([0, 1]),
            (new FormField("min_total"))->required()->regex('/^\d{1,10}(\.\d{1,2})?$/')
                ->range(0, 9999999999.99),
        ];
    }
}
