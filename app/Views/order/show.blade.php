@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4">
                <h1 class="h3 mb-0">Bestellung <?= e($opt["order"]["order_number"]) ?></h1>
            </div>

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
                                    <td class="text-right">
                                        <?= e(number_format((float) $orderItem["price"] * (int) $orderItem["quantity"], 2, ",", ".")) ?> €
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
            <div class="bg-box rounded p-4">
                <h5>Übersicht</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Kunde</span>
                    <span><?= e($opt["order"]["email"] ?? "Gast") ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Status</span>
                    <span><?= $opt["order"]["status"] === "completed" ? "Erledigt" : e($opt["order"]["status"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Bestellt am</span>
                    <span><?= e(date("d.m.Y H:i", strtotime($opt["order"]["created"]))) ?></span>
                </div>
            </div>

            <div class="bg-box rounded p-4 mt-4">
                <h5>Lieferadresse</h5>
                <hr>
                <div><?= e($opt["order"]["recipient"]) ?></div>
                <div><?= e($opt["order"]["address_line_1"]) ?></div>
                <?php if (!empty($opt["order"]["address_line_2"])): ?>
                    <div><?= e($opt["order"]["address_line_2"]) ?></div>
                <?php endif; ?>
                <div><?= e($opt["order"]["postal_code"]) ?> <?= e($opt["order"]["city"]) ?></div>
                <div><?= e($opt["order"]["country"]) ?></div>
            </div>
        </aside>
    </div>
@endsection
