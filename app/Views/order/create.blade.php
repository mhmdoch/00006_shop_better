@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Bestellung abschließen</h1>
    </div>

    <div class="row">
        <main class="col-lg-8">
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
                        <tbody>
                            <?php foreach ($opt["orderItems"] as $orderItem): ?>
                                <tr>
                                    <td>
                                        <a href="<?= $opt["root"] ?>catalog/show/<?= e($orderItem["catalog_id"]) ?>">
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
                                    <td class="text-right"><?= e($orderItem["quantity"]) ?></td>
                                                                        <td class="text-right"><?= bcmul($orderItem["taxrate"], 100, 0) ?> %</td>

                                    <td class="text-right">
                                        <?= e(number_format((float) $orderItem["price"] * (int) $orderItem["quantity"], 2, ",", ".")) ?> €
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th  colspan="6" class="text-right">Zwischensumme</th><th  class="text-right"><?= e($totalSum) ?> €</th></tr>
                            <tr>
                                <th colspan="7" class="text-right"></th>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right small">Steuersatz:</td>
                                <td class="text-right small">Brutto:</td>
                                <td class="text-right small">Netto:</td>
                                <td class="text-right small">Steuer:</td>
                            </tr>     
                            <?php foreach ($opt["taxPot"] as $cartItem): ?>
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
            </div>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4 mt-4">
                <h5>Lieferadresse</h5>
                <hr>
                <div id="create_order"></div>
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {
            var order_create_form = Z.Forms.create({
                dom: "create_order"
            });

            order_create_form.createField({
                name: "recipient",
                type: "text",
                text: "Empfänger",
                required: true
            });
            order_create_form.createField({
                name: "address_line_1",
                type: "text",
                text: "Straße und Hausnummer",
                required: true
            });
            order_create_form.createField({
                name: "address_line_2",
                type: "text",
                text: "Adresszusatz",
                required: false
            });
            order_create_form.createField({
                name: "postal_code",
                type: "text",
                text: "Postleitzahl",
                required: true
            });
            order_create_form.createField({
                name: "city",
                type: "text",
                text: "Ort",
                required: true
            });
            order_create_form.createField({
                name: "country",
                type: "text",
                text: "Land",
                value: "Deutschland",
                required: true
            });

            order_create_form.buttonSubmit.innerHTML = "Bestellung abschließen";
            order_create_form.saveHook = (res) => {
                window.location.href = "<?= $opt["root"] ?>order/show/" + res.orderId;
            };
        });
    </script>
@endsection
