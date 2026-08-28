@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Warenkorb</h1>
    </div>

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
    <?php endif; ?>
@endsection
