@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Bestellungen</h1>
    </div>

    <?php if (empty($opt["orders"])): ?>
        <div class="bg-box rounded p-4 mt-4">
            Es sind keine Bestellungen vorhanden.
        </div>
    <?php else: ?>
        <div class="bg-box rounded p-4 mt-4">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Bestellnummer</th>
                            <th>Kunde</th>
                            <th>Lieferadresse</th>
                            <th class="text-right">Artikel</th>
                            <th class="text-right">Gesamt</th>
                            <th>Status</th>
                            <th>Bestellt am</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($opt["orders"] as $order): ?>
                            <tr>
                                <td><?= e($order["order_number"]) ?></td>
                                <td><?= e($order["email"] ?? "Gast") ?></td>
                                <td>
                                    <?= e($order["recipient"]) ?><br>
                                    <?= e($order["address_line_1"]) ?>
                                    <?php if (!empty($order["address_line_2"])): ?>
                                        <br><?= e($order["address_line_2"]) ?>
                                    <?php endif; ?>
                                    <br><?= e($order["postal_code"]) ?> <?= e($order["city"]) ?>
                                </td>
                                <td class="text-right"><?= e($order["quantity"]) ?></td>
                                <td class="text-right">
                                    <?= e(number_format((float) $order["total"], 2, ",", ".")) ?> €
                                </td>
                                <td>
                                    <?= $order["status"] === "completed" ? "Erledigt" : e($order["status"]) ?>
                                </td>
                                <td><?= e(date("d.m.Y H:i", strtotime($order["created"]))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
@endsection
