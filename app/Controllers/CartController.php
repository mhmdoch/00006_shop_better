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
                $total += (float) $cartItem["price"] * (int) $cartItem["quantity"];
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
            return $res->rerouteUrl("login");
        }

        $itemId = (int) $req->getParameters(0, 1);
        $req->getModel("Cart")->addItem($user->userId, $itemId);

        return $res->rerouteUrl("cart");
    }
}
