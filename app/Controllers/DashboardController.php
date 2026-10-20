<?php

class DashboardController extends z_controller
{
    private const OPEN_STATUSES = ["pending", "confirmed", "paid"];
    private const LOW_STOCK_LIMIT = 5;
    private const REVENUE_DAYS = 30;

    public function action_index(Request $req, Response $res)
    {
        $req->checkPermission("order.manage");

        $since = strtotime("-" . self::REVENUE_DAYS . " days");

        $openOrders = 0;
        $recentOrders = 0;
        $revenue = "0.00";
        foreach ($req->getModel("Order")->getOrders() as $order) {
            if (in_array($order["status"], self::OPEN_STATUSES, true)) $openOrders++;

            // A cancelled order brings no revenue
            if ($order["status"] === "cancelled" || strtotime($order["created"]) < $since) continue;
            $recentOrders++;
            $revenue = bcadd($revenue, $order["total"], 2);
        }

        return $res->render("dashboard/index", [
            "openOrders" => $openOrders,
            "recentOrders" => $recentOrders,
            "revenue" => $revenue,
            "revenueDays" => self::REVENUE_DAYS,
            "lowStockLimit" => self::LOW_STOCK_LIMIT,
            "lowStockAmount" => $req->getModel("Item")->countLowStockItems(self::LOW_STOCK_LIMIT),
            "lowStockItems" => $req->getModel("Item")->getLowStockItems(self::LOW_STOCK_LIMIT, 10),
            "logs" => $req->getModel("LogActive")->getRecentLogs(10),
            "navMenu" => "dashboard",
        ]);
    }
}
