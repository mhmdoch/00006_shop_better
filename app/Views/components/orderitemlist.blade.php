  @props(["orderedItems", "totalSum", "taxPot", "root", "cartIndex"])
  
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
                                <tr>
                                    <td>
                                        <a href="<?= $root ?>catalog/show/<?= e($orderItem["catalog_id"]) ?>">
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
                                        <?= e(number_format((float) $orderItem["price"], 2, ",", ".")) ?> €
                                    </td>
                                    <td class="text-right">
                                        <?= e($orderItem["quantity"]) ?>
                                    @if($cartIndex)
                                        <a href="#" class="raise-cartItem fa-solid fa-square-plus" data-id="<?= e($orderItem["cart_item_id"]) ?>" title="Menge um 1 erhöhen"></a> <a href="#" class="reduce-cartItem fa-solid fa-square-minus" data-id="<?= e($orderItem["cart_item_id"]) ?>" title="Menge um 1 verringern"></a>                                  
                                    @endif
                                    </td>
                                    <td class="text-right"><?= bcmul($orderItem["taxrate"], 100, 0) ?> %</td>

                                    <td class="text-right">
                                        <?= e(number_format((float) $orderItem["price"] * (int) $orderItem["quantity"], 2, ",", ".")) ?> €
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">Zwischensumme</th><th  class="text-right"><?= e($totalSum) ?> €</th></tr>
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
                                    <td colspan="4" class="text-right small"><?= $cartItem["taxrate"] * 100 ?> %</td>
                                    <td class="text-right small"><?= $cartItem["gross"] ?> €</td>
                                    <td class="text-right small"><?= $cartItem["net"] ?> €</td>
                                    <td class="text-right small"><?= $cartItem["tax"] ?> €</td>
                                </tr>
                        <?php endforeach; ?>
                    </tfoot>
                    </table>
                </div>

                @if($cartIndex)
                    <div class="text-right mt-4">
                        <a href="{{ $root }}order/create" class="btn btn-primary">
                            Zur Kasse
                        </a>
                    </div>
                @endif
            </div>