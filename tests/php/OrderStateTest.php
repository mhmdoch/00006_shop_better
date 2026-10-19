<?php

// Plain PHP checks for the price calculation, no framework needed.
// Run with: npm run tests:php

require_once __DIR__ . "/../../app/Helper/OrderState.php";

use App\Helper\OrderState;

$failed = 0;

function check(string $name, $expected, $actual): void {
    global $failed;
    if ($expected === $actual) {
        echo "ok    $name\n";
        return;
    }
    $failed++;
    echo "FAIL  $name\n      expected: " . var_export($expected, true) . "\n      actual:   " . var_export($actual, true) . "\n";
}

function item(string $price, int $quantity, string $taxrate): array {
    return ["price" => $price, "quantity" => $quantity, "taxrate" => $taxrate];
}

function discount(string $type, string $value): array {
    return ["code" => "TEST", "type" => $type, "value" => $value];
}

// Empty cart
$result = OrderState::orderPriceTaxes([]);
check("empty cart has no total", "0.00", $result["totalSum"]);
check("empty cart has no tax pot", [], $result["taxPot"]);

// One tax rate, quantity multiplies the price
$result = OrderState::orderPriceTaxes([item("10.00", 2, "0.19")]);
check("subtotal multiplies quantity", "20.00", $result["subtotal"]);
check("total without discount equals subtotal", "20.00", $result["totalSum"]);
check("net of one rate", "16.80", $result["taxPot"]["0.19"]["net"]);
check("tax of one rate", "3.20", $result["taxPot"]["0.19"]["tax"]);

// Several tax rates stay separate
$result = OrderState::orderPriceTaxes([item("119.00", 1, "0.19"), item("107.00", 1, "0.07")]);
check("two rates add up", "226.00", $result["totalSum"]);
check("net at 19 percent", "100.00", $result["taxPot"]["0.19"]["net"]);
check("tax at 19 percent", "19.00", $result["taxPot"]["0.19"]["tax"]);
check("net at 7 percent", "100.00", $result["taxPot"]["0.07"]["net"]);
check("tax at 7 percent", "7.00", $result["taxPot"]["0.07"]["tax"]);

// Same rate in several positions is one group
$result = OrderState::orderPriceTaxes([item("5.00", 1, "0.19"), item("7.00", 1, "0.19")]);
check("same rate is grouped", 1, count($result["taxPot"]));
check("grouped gross", "12.00", $result["taxPot"]["0.19"]["gross"]);

// Discounts
$result = OrderState::orderPriceTaxes([item("10.00", 2, "0.19")], discount("percent", "10"));
check("percent discount amount", "2.00", $result["discountAmount"]);
check("percent discount total", "18.00", $result["totalSum"]);
check("discount code is passed on", "TEST", $result["discountCode"]);
check("subtotal ignores the discount", "20.00", $result["subtotal"]);

$result = OrderState::orderPriceTaxes([item("10.00", 2, "0.19")], discount("fixed", "5.50"));
check("fixed discount total", "14.50", $result["totalSum"]);

check("percent rounds half up", "0.05", OrderState::getDiscountAmount(discount("percent", "15"), "0.30"));
check("percent rounds down below half", "3.33", OrderState::getDiscountAmount(discount("percent", "33.33"), "10.00"));
check("100 percent is the whole subtotal", "20.00", OrderState::getDiscountAmount(discount("percent", "100"), "20.00"));

$result = OrderState::orderPriceTaxes([item("10.00", 2, "0.19")], discount("fixed", "50.00"));
check("fixed discount is capped at the subtotal", "20.00", $result["discountAmount"]);
check("capped discount leaves nothing to pay", "0.00", $result["totalSum"]);
check("capped discount leaves no tax", "0.00", $result["taxPot"]["0.19"]["tax"]);

// The discount is spread over the tax rates without losing a cent
$result = OrderState::orderPriceTaxes(
    [item("119.00", 1, "0.19"), item("107.00", 1, "0.07")],
    discount("fixed", "10.00"),
);
$grossSum = bcadd($result["taxPot"]["0.19"]["gross"], $result["taxPot"]["0.07"]["gross"], 2);
check("total after fixed discount", "216.00", $result["totalSum"]);
check("tax pot gross adds up to the total", $result["totalSum"], $grossSum);
check("gross at 19 percent after discount", "113.74", $result["taxPot"]["0.19"]["gross"]);
check("gross at 7 percent after discount", "102.26", $result["taxPot"]["0.07"]["gross"]);

foreach (["0.19", "0.07"] as $rate) {
    $group = $result["taxPot"][$rate];
    check("net and tax add up at $rate", $group["gross"], bcadd($group["net"], $group["tax"], 2));
}

// Status transitions
$state = new OrderState();
check("pending can be confirmed or cancelled", ["confirmed", "cancelled"], $state->orderStateNext("pending"));
check("shipped can only be completed", ["completed"], $state->orderStateNext("shipped"));
check("cancelled is final", [], $state->orderStateNext("cancelled"));
check("completed is final", [], $state->orderStateNext("completed"));

echo $failed === 0 ? "\nall passed\n" : "\n$failed failed\n";
exit($failed === 0 ? 0 : 1);
