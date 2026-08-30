<?php

class OrderController extends z_controller
{
    public function action_create(Request $req, Response $res)
    {
        $req->checkPermission("order.create");

        $cart = $req->getModel("Cart")->assertCartExists();
        $cartItems = $req->getModel("Cart")->getItems();

        if ($req->hasFormData()) {
            if (empty($cartItems)) {
                return $res->error();
            }

            $addressForm = $req->validateForm([
                (new FormField("recipient"))->required()->length(2, 255),
                (new FormField("address_line_1"))->required()->length(2, 255),
                (new FormField("address_line_2"))->length(0, 255),
                (new FormField("postal_code"))->required()->length(2, 20),
                (new FormField("city"))->required()->length(2, 100),
                (new FormField("country"))->required()->length(2, 100),
            ]);

            if ($addressForm->hasErrors) {
                return $res->formErrors($addressForm->errors);
            }

            $orderId = $req->getModel("Order")->createOrder($cart["id"], $addressForm);

            return $res->success([
                "orderId" => $orderId,
            ]);
        }

        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem["price"] * $cartItem["quantity"];
        }

        return $res->render("order/create", [
            "cartItems" => $cartItems,
            "total" => $total,
        ]);
    }

    public function action_index(Request $req, Response $res)
    {
        $req->checkPermission("order.index");

        $orders = $req->getModel("Order")->getOrders();

        return $res->render("order/index", [
            "orders" => $orders,
            "title" => "Bestellungen",
            "showCustomer" => true,
        ]);
    }

    public function action_own(Request $req, Response $res)
    {
        $req->checkPermission("order.own");

        $user = $req->getRequestingUser();
        $orders = $req->getModel("Order")->getOrdersByUserId($user->userId);

        return $res->render("order/index", [
            "orders" => $orders,
            "title" => "Meine Bestellungen",
            "showCustomer" => false,
        ]);
    }

    public function action_show(Request $req, Response $res)
    {
        $orderId = $req->getParameters(0, 1);
        $order = $req->getModel("Order")->getOrderById($orderId);

        $user = $req->getRequestingUser();
        $isOwner = $user->isLoggedIn && $user->userId == $order["user_id"];

        if (!$isOwner) {
            $req->checkPermission("order.index");
        }

        $orderItems = $req->getModel("Order")->getItemsByOrderId($orderId);

        $total = 0;
        foreach ($orderItems as $orderItem) {
            $total += $orderItem["price"] * $orderItem["quantity"];
        }

        App\Helper\Breadcrumbs::append($order["order_number"], "/order/show/" . $orderId);

        return $res->render("order/show", [
            "order" => $order,
            "orderItems" => $orderItems,
            "total" => $total,
        ]);
    }
}
