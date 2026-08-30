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
                                <th class="text-right">Summe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($opt["cartItems"] as $cartItem): ?>
                                <tr>
                                    <td>
                                        <a href="<?= $opt["root"] ?>catalog/show/<?= e($cartItem["catalog_id"]) ?>">
                                            <?= e($cartItem["brand_name"]) ?> <?= e($cartItem["catalog_name"]) ?>
                                        </a>
                                    </td>
                                    <?php if ($cartItem["itemable_type"] === "shoe"): ?>
                                        <td><?= e($cartItem["size"]) ?></td>
                                        <td><?= e($cartItem["color"]) ?></td>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                                    <td class="text-right">
                                        <?= e(number_format((float) $cartItem["price"], 2, ",", ".")) ?> €
                                    </td>
                                    <td class="text-right"><?= e($cartItem["quantity"]) ?></td>
                                    <td class="text-right">
                                        <?= e(number_format((float) $cartItem["price"] * (int) $cartItem["quantity"], 2, ",", ".")) ?> €
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Gesamt</th>
                                <th class="text-right">
                                    <?= e(number_format((float) $opt["total"], 2, ",", ".")) ?> €
                                </th>
                            </tr>
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
