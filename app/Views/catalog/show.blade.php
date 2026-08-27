@extends($layout)

@section("content")



<div class="row">
    <main class="col-lg-8" id="brandIndexContainer">
        <div class="bg-box rounded p-4">
            <h3><?= $opt["catalog"]["brand_name"] ?> <?= $opt["catalog"]["name"] ?></h3>
        </div>

        <div class="bg-box rounded p-4 mt-4">
            <img src="<?php $opt["generateResourceLink"]("assets/img/{$opt["catalog"]["itemable_type"]}.png"); ?>" class="card-img-top">
        </div>

        <?php if ($opt["catalog"]["itemable_type"] === "shoe"): ?>
            <div class="bg-box rounded p-4 mt-4">
                <p class="font-weight-bold mb-2">Größe wählen</p>
                <div class="d-flex flex-wrap mb-3">
                    <a href="<?= $opt["root"] ?>catalog/show/<?= e($opt["catalog"]["id"]) ?>"
                       class="btn <?= $opt["currentSize"] === "all" ? "btn-secondary" : "btn-outline-secondary" ?> mr-2 mb-2">
                        Alle
                    </a>
                    <?php foreach ($opt["sizes"] as $size): ?>
                        <a href="<?= $opt["root"] ?>catalog/show/<?= e($opt["catalog"]["id"]) ?>?size=<?= rawurlencode($size) ?>"
                           class="btn <?= $opt["currentSize"] === $size ? "btn-secondary" : "btn-outline-secondary" ?> mr-2 mb-2">
                            <?= e($size) ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <p class="font-weight-bold mb-2">
                    <?= $opt["currentSize"] === "all" ? "Zuerst Größe wählen" : "Farbe wählen" ?>
                </p>
                <div class="d-flex flex-wrap">
                    <?php foreach ($opt["colors"] as $color): ?>
                        <?php if ($opt["currentSize"] === "all"): ?>
                            <button type="button" class="btn btn-outline-secondary mr-2 mb-2" disabled>
                                <?= e($color) ?>
                            </button>
                        <?php else: ?>
                            <a href="<?= $opt["root"] ?>catalog/show/<?= e($opt["catalog"]["id"]) ?>?size=<?= rawurlencode($opt["currentSize"]) ?>&amp;color=<?= rawurlencode($color) ?>"
                               class="btn <?= $opt["currentColor"] === $color ? "btn-secondary" : "btn-outline-secondary" ?> mr-2 mb-2">
                                <?= e($color) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($opt["selectedItem"] !== null): ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Preis</span>
                        <strong><?= e(number_format((float) $opt["selectedItem"]["price"], 2, ",", ".")) ?> €</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Bestand</span>
                        <span>
                            <?php if ((int) $opt["selectedItem"]["stock"] > 5): ?>
                                mehr als 5
                            <?php else: ?>
                                <?= e($opt["selectedItem"]["stock"]) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="bg-box rounded p-4 mt-4">
            <a href="/brand/show/"></a>
            <a href="/brand/edit/<?= $opt["catalog"]["id"] ?>" class="bi bi-wrench" data-id="" title="editieren"></a> <a href="#" class="delete-brand bi bi-trash3" data-id="" title="löschen"></a>
        </div>
    </main>

    <aside class="col-lg-4">
        <div class="bg-box rounded p-4">
            <h5>Übersicht</h5>
            <hr>
            <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.create")): ?>
                <div class="d-flex justify-content-between">
                    <span>Status</span>
                    <span><?= (e($opt["catalog"]["active"]) == true) ? "<span style='color:green;font-weight:bold;'>aktiv</span>" : "<span style='color:darkred'>gelöscht</span>" ?></span>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between">
                <span>Varianten</span>
                <span><?= count($opt["items"]) ?></span>
            </div>

            <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.create")): ?>
                <div class="d-flex justify-content-between mt-2">
                    <span> <?php if ($opt["catalog"]["itemable_type"] === "shoe") { ?>
                            <a href="/item/itemShoeCreate/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                        <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>
                            <a href="/item/itemLegoCreate/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                        <?php } ?></span>
                    <span></span>
                </div>
            <?php endif; ?>

        </div>
    </aside>
</div>

Data from a model:
<ul>
    <li>
        <?= $opt["catalog"]["name"] ?> </li>

    <?php foreach ($opt["items"] as $item) { ?>
        <li>
            <?= e($item["color"]) ?> <?= e($item["size"]) ?> <?= e($item["price"]) ?>
            <?php if ($opt["catalog"]["itemable_type"] === "shoe") { ?>
                <a href="/item/itemShoeEdit/<?= e($item["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a>
            <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>

            <?php } ?>
        </li>
    <?php } ?>
</ul>
@endsection
