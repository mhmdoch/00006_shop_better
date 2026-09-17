@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Warenkorb</h1>
    </div>

    <div id="cartNotification" class="alert alert-danger d-none mt-4" role="alert"></div>

    <?php if (empty($opt["cartItems"])): ?>
        <div class="bg-box rounded p-4 mt-4">
            Dein Warenkorb ist leer.
        </div>
    <?php else: ?>
        <div class="bg-box rounded p-4 mt-4">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Artikel</th>
                            <th>Größe</th>
                            <th>Farbe</th>
                            <th class="text-right">Preis</th>
                            <th class="text-right">Menge</th>
                            <th class="text-right">USt.</th>
                            <th class="text-right">Summe</th>
                        </tr>
                    </thead>
                    <tbody id="cartItemList">
                        <?php foreach ($opt["cartItems"] as $cartItem): ?>
                            <tr>
                                <td><a href="#" class="delete-cartItem fa-solid fa-trash"data-id="<?= e($cartItem["cart_item_id"]) ?>" title="löschen"></a></td>
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
                                <td class="text-right"><?= e($cartItem["quantity"]) ?> <a href="#" class="raise-cartItem fa-solid fa-square-plus" data-id="<?= e($cartItem["cart_item_id"]) ?>" title="Menge um 1 erhöhen"></a> <a href="#" class="reduce-cartItem fa-solid fa-square-minus" data-id="<?= e($cartItem["cart_item_id"]) ?>" title="Menge um 1 verringern"></a></td>
                                <td class="text-right"><?= bcmul($cartItem["taxrate"], '100', 0); ?> %</td>
                                <td class="text-right">
                                    <?= e(number_format((float) $cartItem["price"] * (int) $cartItem["quantity"], 2, ",", ".")) ?> €
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr>
                        <th  colspan="7" class="text-right">Zwischensumme</th><th  class="text-right"><?= e($totalSum) ?> €</th></tr>
                        <tr>
                            <th colspan="8" class="text-right"></th>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right small">Steuersatz:</td>
                            <td class="text-right small">Brutto:</td>
                            <td class="text-right small">Netto:</td>
                            <td class="text-right small">Steuer:</td>
                        </tr>     
                        <?php foreach ($opt["taxPot"] as $cartItem): ?>
                            <tr>
                                <td colspan="5" class="text-right small"><?= $cartItem["taxrate"] * 100 ?> %</td>
                                <td class="text-right small"><?= $cartItem["gross"] ?> €</td>
                                <td class="text-right small"><?= $cartItem["net"] ?> €</td>
                                <td class="text-right small"><?= $cartItem["tax"] ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </tfoot>
                </table>
            </div>

            <div class="text-right mt-4">
                <a href="<?= $opt["root"] ?>order/create" class="btn btn-primary">
                    Zur Kasse
                </a>
            </div>
        </div>


        <script>
    $(document).ready(function() {
        $("#cartItemList").on("click", ".delete-cartItem", function(event) {
            // der Link wird hier eh nicht ausgeführt, aber damit verhindere ich hier an der Stelle
            // dass der Cursor wieder zum Seitenanfang geht
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('delete-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                alert("An error occurred");
            });
        });


        $("#cartItemList").on("click", ".raise-cartItem", function(event) {
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('raise-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    if (res.notificationShow) {
                        $("#cartNotification").text(res.notificationMSG).removeClass("d-none");
                        return;
                    }
                    location.reload();
                    return;
                }
                alert(JSON.stringify(res.message.message) || "An error occurred");
            });
        });

        $("#cartItemList").on("click", ".reduce-cartItem", function(event) {
            event.preventDefault();

            var id = $(this).data("id");

            Z.Request.action('reduce-cartItem', {
                cartItemId: id
            }, (res) => {
                if (res.result == 'success') {
                    location.reload();
                    return;
                }
                alert("An error occurred");
            });
        });
    });
</script>

    <?php endif; ?>
@endsection
