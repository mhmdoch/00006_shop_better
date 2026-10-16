<?php

use \App\Helper\OrderState;

class OrderController extends z_controller
{
    public function action_create(Request $req, Response $res)
    {

        $cart = $req->getModel("Cart")->assertCartExists();
        $cartItems = $req->getModel("Cart")->getItems();

        $orderItems = $cartItems;

        $priceTaxes = $req->getModel("Cart")->getPriceTaxes($cart["id"], $orderItems);
        if ($priceTaxes["discountMessage"] !== null) {
            if ($req->hasFormData()) return $res->success(["cartChanged" => true]);
            return $res->rerouteUrl("cart");
        }
        $taxPot = $priceTaxes['taxPot'];
        $totalSum = $priceTaxes['totalSum'];

        if ($req->hasFormData()) {
            if (empty($cartItems)) {
                return $res->error();
            }

            $addressForm = $req->validateForm([
                (new FormField("recipient"))->required()->length(2, 255),
                (new FormField("email"))->required()->length(2, 255),               
                (new FormField("address_line_1"))->required()->length(2, 255),
                (new FormField("address_line_2"))->length(0, 255),
                (new FormField("postal_code"))->required()->length(2, 20),
                (new FormField("city"))->required()->length(2, 100),
                (new FormField("country"))->required()->length(2, 100),
            ]);

            if ($addressForm->hasErrors) {
                return $res->formErrors($addressForm->errors);
            }

            $token = bin2hex(random_bytes(32));

            $orderId = $req->getModel("Order")->createOrder(
                $cart["id"],
                $addressForm,
                $token
            );

            $order = $req->getModel("Order")->getOrderById($orderId);
            $items = $req->getModel("Order")->getItemsByOrderId($orderId);
            $priceTaxes = OrderState::orderPriceTaxes(
                $items,
                $req->getModel("Cart")->getDiscountByCartId($order["cart_id"])
            );

            $res->sendEmail(
                $order["email"],                    // Recipient
                "Bestellinformationen",             // Subject
                "email/orderconfirmation",          // View file
                "en",                               // Language
                [
                    "order" => $order,
                    "items" => $items,
                    "totalSum" => $priceTaxes["totalSum"],
                    "taxPot" => $priceTaxes["taxPot"],
                    "subtotal" => $priceTaxes["subtotal"],
                    "discountAmount" => $priceTaxes["discountAmount"],
                    "discountCode" => $priceTaxes["discountCode"],
                ],
                "mail_layout",                      // Layout file
            );


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
            "orderItems" => $orderItems,
            "total" => $total,
            "totalSum" => $totalSum,
            "taxPot" => $taxPot,
            "subtotal" => $priceTaxes["subtotal"],
            "discountAmount" => $priceTaxes["discountAmount"],
            "discountCode" => $priceTaxes["discountCode"],
            "navMenu" => "order",
        ]);
    }

    public function action_index(Request $req, Response $res)
    {
        $req->checkPermission("order.manage");

        $orders = $req->getModel("Order")->getOrders();

        return $res->render("order/index", [
            "orders" => $orders,
            "title" => "Bestellungen",
            "showCustomer" => true,
            "navMenu" => "allorder",
        ]);
    }

    public function action_own(Request $req, Response $res)
    {
        $user = $req->getRequestingUser();

        if (!$user->isLoggedIn) {
            return $res->reroute(["login", "index"]);
        }

        $orders = $req->getModel("Order")->getOrdersByUserId($user->userId);

        return $res->render("order/index", [
            "orders" => $orders,
            "title" => "Meine Bestellungen",
            "showCustomer" => false,
            "navMenu" => "order",
        ]);
    }

    public function action_guest(Request $req, Response $res) 
    {
        $token = $req->getParameters(0, 1);

        if (!$token) {
            return $res->reroute(["error", "404"]);
        }

        $order = $req->getModel("Order")->getOrderByToken($token);

        if ($order === null) {
            return $res->reroute(["error", "404"]);
        }


        $orderItems = $req->getModel("Order")->getItemsByOrderId($order["id"]);

        $priceTaxes = OrderState::orderPriceTaxes(
            $orderItems,
            $req->getModel("Cart")->getDiscountByCartId($order["cart_id"])
        );
        $taxPot = $priceTaxes['taxPot'];
        $totalSum = $priceTaxes['totalSum'];

        $total = 0;
        foreach ($orderItems as $orderItem) {
            $total += $orderItem["price"] * $orderItem["quantity"];
        }


        return $res->render("order/guest", [
            "order" => $order,
            "orderItems" => $orderItems,
            "total" => $total,
            "taxPot" => $taxPot,
            "totalSum" => $totalSum,
            "subtotal" => $priceTaxes["subtotal"],
            "discountAmount" => $priceTaxes["discountAmount"],
            "discountCode" => $priceTaxes["discountCode"],
            "navMenu" => "order",
        ]);
    }

    public function action_show(Request $req, Response $res)
    {
        $orderId = $req->getParameters(0, 1);

        $order = $req->getModel("Order")->getOrderById($orderId);

        if ($order === null) {
            return $res->reroute(["error", "404"]);
        }

        $user = $req->getRequestingUser();
        $isOwner = ($user->isLoggedIn) && ($user->userId == $order["user_id"]);

        if (!$isOwner) {
            $req->checkPermission("order.manage");
        }

        $stateMachine = new \App\Helper\OrderState();
        $statuses = $stateMachine->orderStateNext($order["status"]);

        if ($req->hasFormData()) {
            $req->checkPermission("order.manage");

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

            $res->sendEmail(
                $order["email"],
                "Status deiner Bestellung",
                "email/orderstatus",
                "de",
                [
                    "order" => $order,
                    "status" => $statusForm->getValue("status"),
                ],
                "mail_layout",
            );

            return $res->success();
        }


        $orderItems = $req->getModel("Order")->getItemsByOrderId($orderId);

        $priceTaxes = OrderState::orderPriceTaxes(
            $orderItems,
            $req->getModel("Cart")->getDiscountByCartId($order["cart_id"])
        );
        $taxPot = $priceTaxes['taxPot'];
        $totalSum = $priceTaxes['totalSum'];


        $logs = $req->getModel("LogActive")->getLogByidAndType($orderId, "order");

        $total = 0;
        foreach ($orderItems as $orderItem) {
            $total += $orderItem["price"] * $orderItem["quantity"];
        }

        if ($isOwner) {
            App\Helper\Breadcrumbs::append("Meine Bestellungen", "/order/own/");
        }

        App\Helper\Breadcrumbs::append($order["order_number"], "/order/show/" . $orderId);

        return $res->render("order/show", [
            "order" => $order,
            "orderItems" => $orderItems,
            "total" => $total,
            "canEditStatus" => $req->checkPermission("order.manage", true),
            "statuses" => json_encode($statuses),
            "taxPot" => $taxPot,
            "totalSum" => $totalSum,
            "subtotal" => $priceTaxes["subtotal"],
            "discountAmount" => $priceTaxes["discountAmount"],
            "discountCode" => $priceTaxes["discountCode"],
            'logs' => $logs,
            "navMenu" => "order",
        ]);
    }
}
