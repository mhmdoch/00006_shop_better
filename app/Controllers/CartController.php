<?php

class CartController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $user = user();
        $cartItems = [];
        $total = 0;

        if ($user->isLoggedIn) {
            $cartItems = $req->getModel("Cart")->getItemsByUserId($user->userId);

            foreach ($cartItems as $cartItem) {
                $total += $cartItem["price"] * $cartItem["quantity"];
            }
        }


        return $res->render("cart/index", [
            "cartItems" => $cartItems,
            "total" => $total,
        ]);
    }

    public function action_add(Request $req, Response $res)
    {
        $user = user();

        if (!$user->isLoggedIn) {
            return $res->render("cart/index", [
                "cartItems" => [],
                "total" => 0,
            ]);
        }

        $itemId = $req->getParameters(0, 1);
        $cart = $req->getModel("Cart")->getCartByUserId($user->userId);

        if (empty($cart)) {
            $req->getModel("Cart")->createCart($user->userId);
            $cart = $req->getModel("Cart")->getCartByUserId($user->userId);
        }

        $req->getModel("Cart")->addItem($cart["id"], $itemId);

        $cartItems = $req->getModel("Cart")->getItemsByUserId($user->userId);
        $total = 0;

        foreach ($cartItems as $cartItem) {
            $total += $cartItem["price"] * $cartItem["quantity"];
        }

        return $res->render("cart/index", [
            "cartItems" => $cartItems,
            "total" => $total,
        ]);
    }
}
