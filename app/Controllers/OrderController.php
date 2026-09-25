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


        $orderItems = $cartItems;

        $grossPot = [];
        $totalSum = 0;

        foreach ($orderItems as $orderItem) {
            $taxrate = $orderItem["taxrate"];
            $grossPrice = $orderItem["price"];
            $quantity = $orderItem["quantity"];

            $orderItemFullPrice = bcmul($grossPrice, $quantity, 2);
            $totalSum = bcadd($totalSum, $orderItemFullPrice, 2);


            if (!isset($grossPot[$taxrate])) {
                $grossPot[$taxrate] = '0.00';
            }

            $grossPot[$taxrate] = bcadd($grossPot[$taxrate], $orderItemFullPrice, 2);
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


      


        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem["price"] * $cartItem["quantity"];
        }

        return $res->render("order/create", [
            "cartItems" => $cartItems,
            "orderItems" => $orderItems,
            "total" => $total,
            "totalSum" => $totalSum,
            "taxPot" => $taxPot
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

        $stateMachine = new \App\Helper\OrderState();
        $statuses = $stateMachine->orderStateNext($order["status"]);

        if ($req->hasFormData()) {
            $req->checkPermission("order.index");

            $statusForm = $req->validateForm([
                (new FormField("status"))
                    ->required()
                    ->in($statuses),
            ]);

            if ($statusForm->hasErrors) {
                return $res->formErrors($statusForm->errors);
            }

            if ($statusForm->getValue("status") == "cancelled") {
                $res->getModel("Order")->restockOrder($orderId);
            }

            $res->insertDatabase(
                "log_active",
                new FormResult(),
                [
                    "userId" => user()->userId,
                    "active_type" => "order",
                    "active_id" => $orderId,
                    "action" => $statusForm->getValue("status"),
                ]
            );
            $req->getModel("Order")->updateStatus((int) $orderId, $statusForm->getValue("status"));

            return $res->success();
        }


        $user = $req->getRequestingUser();
        $isOwner = $user->isLoggedIn && $user->userId == $order["user_id"];

        if (!$isOwner) {
            $req->checkPermission("order.index");
        }

        $orderItems = $req->getModel("Order")->getItemsByOrderId($orderId);

        $grossPot = [];
        $totalSum = 0;

        foreach ($orderItems as $orderItem) {
            $taxrate = $orderItem["taxrate"];
            $grossPrice = $orderItem["price"];
            $quantity = $orderItem["quantity"];

            $orderItemFullPrice = bcmul($grossPrice, $quantity, 2);
            $totalSum = bcadd($totalSum, $orderItemFullPrice, 2);


            if (!isset($grossPot[$taxrate])) {
                $grossPot[$taxrate] = '0.00';
            }

            $grossPot[$taxrate] = bcadd($grossPot[$taxrate], $orderItemFullPrice, 2);
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


      


        $total = 0;
        foreach ($orderItems as $orderItem) {
            $total += $orderItem["price"] * $orderItem["quantity"];
        }

        if ($order["user_id"] === $user->userId) {
            App\Helper\Breadcrumbs::append("Meine Bestellungen", "/order/own/");
        }

        App\Helper\Breadcrumbs::append($order["order_number"], "/order/show/" . $orderId);

        return $res->render("order/show", [
            "order" => $order,
            "orderItems" => $orderItems,
            "total" => $total,
            "canEditStatus" => $req->checkPermission("order.index", true),
            "statuses" => json_encode($statuses),
            "taxPot" => $taxPot,
            "totalSum" => $totalSum,
        ]);
    }
}
