<?php

use \App\Helper\OrderState;

class CartController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $cart = $req->getModel("Cart")->assertCartExists();
        $cartItems = $req->getModel("Cart")->getItems();

        if ($req->isAction("apply-discount")) {
            $discountForm = $req->validateForm([
                (new FormField("code"))->required()->length(1, 100),
            ]);

            if ($discountForm->hasErrors || empty($cartItems)) {
                return $res->error("Bitte gib einen gültigen Rabattcode für deinen Warenkorb ein.");
            }

            $code = trim($discountForm->getValue("code"));
            $discount = $req->getModel("Discount")->getDiscountByCode($code);
            $priceTaxes = OrderState::orderPriceTaxes($cartItems);
            $error = $req->getModel("Discount")->getDiscountError($discount, $priceTaxes["subtotal"]);

            if ($error !== null) return $res->error($error);

            $req->getModel("Cart")->setDiscountByCartId($cart["id"], $discount["id"]);
            return $res->success();
        }

        if ($req->isAction("add-item")) {
            $req->getModel("Cart")->addItem($cart["id"], (int) $req->getPost("itemId"));
            return $res->success();
        }

        if ($req->isAction("remove-discount")) {
            $req->getModel("Cart")->setDiscountByCartId($cart["id"], null);
            return $res->success();
        }

        if ($req->isAction("delete-cartItem")) {
            //$req->checkPermission("brand.delete");
            $cartItemId = $req->getPost("cartItemId");
            $req->getModel("Cart")->deleteCartItemById($cartItemId);
            return $res->success();
        }

        if ($req->isAction("raise-cartItem")) {
            //$req->checkPermission("brand.delete");
            $cartItemId = $req->getPost("cartItemId");
            $cartItemQuantityBefore = $req->getModel("Cart")->getCartItemQuantityById($cartItemId);
            $req->getModel("Cart")->raiseCartItemById($cartItemId);
            $cartItemQuantityAfter = $req->getModel("Cart")->getCartItemQuantityById($cartItemId);
            if ($cartItemQuantityAfter > $cartItemQuantityBefore) {
                return $res->success();
            } else {

                return $res->success([
                    "notificationShow" => true,
                    "notificationMSG" => "Lagerbestand reicht nicht aus.",
                ]);
            }
        }

        if ($req->isAction("reduce-cartItem")) {
            //$req->checkPermission("brand.delete");
            $cartItemId = $req->getPost("cartItemId");
            $req->getModel("Cart")->reduceCartItemById($cartItemId);
            return $res->success();
        }

        $priceTaxes = $req->getModel("Cart")->getPriceTaxes($cart["id"], $cartItems);
        if ($priceTaxes["discountMessage"] !== null) {
            $req->getModel("Cart")->setDiscountByCartId($cart["id"], null);
        }

        return $res->render("cart/index", [
            "cartItems" => $cartItems,
            "taxPot" => $priceTaxes["taxPot"],
            "totalSum" => $priceTaxes["totalSum"],
            "subtotal" => $priceTaxes["subtotal"],
            "discountAmount" => $priceTaxes["discountAmount"],
            "discountCode" => $priceTaxes["discountCode"],
            "discountMessage" => $priceTaxes["discountMessage"],
            "navMenu" => "cart",
        ]);
    }
}
