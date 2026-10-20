@extends($layout)

@section("content")
    <div class="row">
        <main class="col-12">
            <div class="bg-box rounded p-4">
                <h3 class="mb-0">Dashboard</h3>
            </div>
        </main>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="bg-box rounded p-4 h-100">
                <p class="brand-kicker mb-1">Offene Bestellungen</p>
                <h2 class="mb-1" data-test="dashboard-open-orders"><?= e($opt["openOrders"]) ?></h2>
                <a href="<?= e($opt["root"]) ?>order">alle Bestellungen</a>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="bg-box rounded p-4 h-100">
                <p class="brand-kicker mb-1">Umsatz der letzten <?= e($opt["revenueDays"]) ?> Tage</p>
                <h2 class="mb-1" data-test="dashboard-revenue"><?= e(\App\Helper\AppHelper::price($opt["revenue"])) ?></h2>
                <span class="text-muted"><span data-test="dashboard-recent-orders"><?= e($opt["recentOrders"]) ?></span> Bestellungen ohne Stornierungen</span>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="bg-box rounded p-4 h-100">
                <p class="brand-kicker mb-1">Niedriger Bestand (höchstens <?= e($opt["lowStockLimit"]) ?>)</p>
                <h2 class="mb-1" data-test="dashboard-low-stock-amount"><?= e($opt["lowStockAmount"]) ?></h2>
                <span class="text-muted">Varianten im Verkauf</span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="bg-box rounded p-4 h-100">
                <h5>Bald ausverkauft</h5>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody data-test="dashboard-low-stock">
                            <?php if (empty($opt["lowStockItems"])): ?>
                                <tr><td>Kein Artikel mit niedrigem Bestand.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($opt["lowStockItems"] as $item): ?>
                                <tr>
                                    <td>
                                        <a href="<?= e($opt["root"]) ?>catalog/show/<?= e($item["catalog_id"]) ?>">
                                            <?= e($item["brand_name"]) ?> <?= e($item["catalog_name"]) ?>
                                        </a>
                                        <span class="text-muted">
                                            <?= e($item["item_name"] ?? trim(($item["color"] ?? "") . " " . ($item["size"] ?? ""))) ?>
                                        </span>
                                    </td>
                                    <td class="text-right text-nowrap"><?= e($item["stock"]) ?> Stück</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="bg-box rounded p-4 h-100">
                <h5>Letzte Aktivitäten</h5>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody data-test="dashboard-logs">
                            <?php if (empty($opt["logs"])): ?>
                                <tr><td>Noch keine Aktivitäten.</td></tr>
                            <?php endif; ?>
                            <?php foreach ($opt["logs"] as $log): ?>
                                <tr>
                                    <td>
                                        <?php if ($log["active_type"] === "order"): ?>
                                            <a href="<?= e($opt["root"]) ?>order/show/<?= e($log["active_id"]) ?>">Bestellung <?= e($log["active_id"]) ?></a>
                                        <?php elseif ($log["active_type"] === "brand"): ?>
                                            <a href="<?= e($opt["root"]) ?>brand/show/<?= e($log["active_id"]) ?>">Marke <?= e($log["active_id"]) ?></a>
                                        <?php else: ?>
                                            <?= e(ucfirst($log["active_type"])) ?> <?= e($log["active_id"]) ?>
                                        <?php endif; ?>
                                        <strong><?= e($log["action"]) ?></strong>
                                        <br><span class="text-muted"><?= e($log["userEmail"]) ?></span>
                                    </td>
                                    <td class="text-right text-nowrap"><?= e(date("d.m.Y H:i", strtotime($log["date"]))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
