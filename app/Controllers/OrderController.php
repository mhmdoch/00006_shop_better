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
}
