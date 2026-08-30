<?php

class OrderController extends z_controller
{
    public function action_index(Request $req, Response $res)
    {
        $req->checkPermission("order.index");

        $orders = $req->getModel("Order")->getOrders();

        return $res->render("order/index", [
            "orders" => $orders,
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
