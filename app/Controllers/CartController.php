<?php

class CartController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $cartItems = $req->getModel("Cart")->getItems();

        $grossPot = [];
        $totalSum = 0;

        foreach ($cartItems as $cartItem) {
            $taxrate = $cartItem["taxrate"];
            $grossPrice = $cartItem["price"];
            $quantity = $cartItem["quantity"];

            $cartItemFullPrice = bcmul($grossPrice, $quantity, 2);
            $totalSum = bcadd($totalSum, $cartItemFullPrice, 2);


            if (!isset($grossPot[$taxrate])) {
                $grossPot[$taxrate] = '0.00';
            }

            $grossPot[$taxrate] = bcadd($grossPot[$taxrate], $cartItemFullPrice, 2);
        }

        $taxPot = [];
        foreach ($grossPot as $taxrate => $grossAmount) {
            $netAmount = bcdiv($grossAmount, bcadd('1', $taxrate, 2), 2);
            $taxAmount = bcsub($grossAmount, $netAmount, 2);
            $taxPot[$taxrate] = [
                'gross' => $grossAmount,
                'net' => $netAmount,
                'tax' => $taxAmount,
                'taxrate' => $taxrate,
                ];}

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

        return $res->render("cart/index", [
            "cartItems" => $cartItems,
            "taxPot" => $taxPot,
            "totalSum" => $totalSum,
        ]);
    }

    public function action_add(Request $req, Response $res)
    {
        $itemId = $req->getParameters(0, 1);

        $cart = $req->getModel("Cart")->assertCartExists();

        $req->getModel("Cart")->addItem($cart["id"], $itemId);
        return $res->rerouteUrl("cart");
    }
}
