<?php

class CartController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $cartItems = $req->getModel("Cart")->getItems();

        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem["price"] * $cartItem["quantity"];
        }

        return $res->render("cart/index", [
            "cartItems" => $cartItems,
            "total" => $total,
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
