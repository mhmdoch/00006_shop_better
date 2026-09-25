<?php

namespace App\Helper;

class OrderState
{

    public function orderStateNext($orderState): array
    {
        return match ($orderState) {
            "pending"   => ["confirmed", "cancelled"],
            "confirmed" => ["paid", "cancelled"],
            "paid"      => ["shipped", "cancelled"],
            "shipped"   => ["completed"],
            "completed", "cancelled" => [],

        };

        // das hier als enum
        // und methode status änderung zu
    }
}
