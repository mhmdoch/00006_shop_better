  @props(["orderedItems", "totalSum", "taxPot", "root", "cartIndex" => false, "subtotal" => null, "discountAmount" => "0.00", "discountCode" => null])
  
  <div class="bg-box rounded p-4 mt-4">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Artikel</th>
                                <th>Größe</th>
                                <th>Farbe</th>
                                <th class="text-right">Preis</th>
                                <th class="text-right">Menge</th>
                                <th class="text-right">USt.</th>
                                <th class="text-right">Summe</th>
                            </tr>
                        </thead>
                        <tbody class="cartItemList">
                            <?php foreach ($orderedItems as $orderItem): ?>
                                <tr data-test="order-element">
                                    <td>
                                        <a href="<?= e($root) ?>catalog/show/<?= e($orderItem["catalog_id"]) ?>" data-test="order-element-link">
                                            <?= e($orderItem["brand_name"]) ?> <?= e($orderItem["catalog_name"]) ?>
                                        </a>
                                    </td>
                                    <?php if ($orderItem["itemable_type"] === "shoe"): ?>
                                        <td><?= e($orderItem["size"]) ?></td>
                                        <td><?= e($orderItem["color"]) ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <td class="text-right">
                                        <?= e(\App\Helper\AppHelper::price($orderItem["price"])) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= e($orderItem["quantity"]) ?>
                                    @if($cartIndex)
                                        <a href="#" class="raise-cartItem fa-solid fa-square-plus" data-id="<?= e($orderItem["cart_item_id"]) ?>" title="Menge um 1 erhöhen" data-test="order-raise"></a> <a href="#" class="reduce-cartItem fa-solid fa-square-minus" data-id="<?= e($orderItem["cart_item_id"]) ?>" title="Menge um 1 verringern"  data-test="order-reduce"></a>
                                    @endif
                                    </td>
                                    <td class="text-right"><?= bcmul($orderItem["taxrate"], 100, 0) ?> %</td>

                                    <td class="text-right">
                                        <?= e(\App\Helper\AppHelper::price((float) $orderItem["price"] * (int) $orderItem["quantity"])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Zwischensumme</th>
                                <th class="text-right"><?= e(\App\Helper\AppHelper::price($subtotal ?? $totalSum)) ?></th>
                            </tr>
                            <?php if ($discountCode !== null): ?>
                                <tr>
                                    <td colspan="6" class="text-right">Rabattcode <?= e($discountCode) ?></td>
                                    <td class="text-right" data-test="order-discount">-<?= e(\App\Helper\AppHelper::price($discountAmount)) ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th colspan="6" class="text-right">Gesamtsumme</th>
                                <th class="text-right" data-test="order-total"><?= e(\App\Helper\AppHelper::price($totalSum)) ?></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right"></th>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right small">Steuersatz:</td>
                                <td class="text-right small">Brutto:</td>
                                <td class="text-right small">Netto:</td>
                                <td class="text-right small">Steuer:</td>
                            </tr>     
                            <?php foreach ($taxPot as $cartItem): ?>
                                <tr>
                                    <td colspan="4" class="text-right small"><?= e(bcmul($cartItem["taxrate"], '100', 0)) ?> %</td>
                                    <td class="text-right small" data-test="order_gross"><?= e(\App\Helper\AppHelper::price($cartItem["gross"])) ?></td>
                                    <td class="text-right small" data-test="order_net"><?= e(\App\Helper\AppHelper::price($cartItem["net"])) ?></td>
                                    <td class="text-right small" data-test="order_tax"><?= e(\App\Helper\AppHelper::price($cartItem["tax"])) ?></td>
                                </tr>
                        <?php endforeach; ?>
                    </tfoot>
                    </table>
                </div>

                @if($cartIndex)
                    <div class="mt-4">
                        <?php if ($discountCode !== null): ?>
                            <span>Rabattcode <?= e($discountCode) ?> ist angewendet.</span>
                            <button type="button" id="removeDiscount" class="btn btn-outline-secondary ml-2" data-test="remove-discount">Entfernen</button>
                        <?php else: ?>
                            <label for="discountCode">Rabattcode</label>
                            <div class="input-group">
                                <input type="text" id="discountCode" class="form-control" maxlength="100" data-test="discount-code">
                                <div class="input-group-append">
                                    <button type="button" id="applyDiscount" class="btn btn-primary" data-test="apply-discount">Einlösen</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ $root }}order/create" class="btn btn-primary" data-test="order-checkout">
                            Zur Kasse
                        </a>
                    </div>
                @endif
            </div>
