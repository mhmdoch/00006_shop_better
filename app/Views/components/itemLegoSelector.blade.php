@props(["opt"])

<div class="bg-box rounded p-4 mt-4">
    <?php if (count($opt["items"]) > 1): ?>
        <p class="font-weight-bold mb-2">Variante wählen</p>
        <div class="d-flex flex-wrap mb-3">
            <?php foreach ($opt["items"] as $item): ?>
                <a href="<?= $opt["root"] ?>catalog/show/<?= e($opt["catalog"]["id"]) ?>?item=<?= rawurlencode($item["id"]) ?>"
                   data-test="variant_item"
                   class="btn <?= $opt["selectedItem"] !== null && (int) $opt["selectedItem"]["id"] === (int) $item["id"] ? "btn-secondary" : "btn-outline-secondary" ?> mr-2 mb-2">
                    <?= e($item["name"] ?: $item["sku"]) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($opt["selectedItem"] !== null): ?>
        <?php if (count($opt["items"]) > 1): ?><hr><?php endif; ?>
        <div class="d-flex justify-content-between">
            <span>Setnummer</span>
            <span data-test="variant_set_number"><?= e($opt["selectedItem"]["set_number"]) ?></span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Thema</span>
            <span data-test="variant_theme"><?= e($opt["selectedItem"]["theme"]) ?></span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Teile</span>
            <span data-test="variant_piece_count"><?= e(number_format((int) $opt["selectedItem"]["piece_count"], 0, ",", ".")) ?></span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Erscheinungsdatum</span>
            <span data-test="variant_release_date"><?= e(date("d.m.Y", strtotime($opt["selectedItem"]["release_date"]))) ?></span>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <span>Preis</span>
            <strong data-test="variant_price"><?= e(\App\Helper\AppHelper::price($opt["selectedItem"]["price"])) ?></strong>
        </div>
        <div class="d-flex justify-content-between">
            <span>Bestand</span>
            <span data-test="variant_stock">
                <?php if ((int) $opt["selectedItem"]["stock"] > 5): ?>
                    mehr als 5
                <?php else: ?>
                    <?= e($opt["selectedItem"]["stock"]) ?>
                <?php endif; ?>
            </span>
        </div>

        <a
            href="#"
            class="btn cart-button btn-block mt-3 <?= (int) $opt["selectedItem"]["stock"] === 0 ? "disabled" : "" ?>"
            data-test="variant_add_to_cart"
            data-item-id="<?= e($opt["selectedItem"]["id"]) ?>"
            <?= (int) $opt["selectedItem"]["stock"] === 0 ? 'aria-disabled="true"' : "" ?>
        >
            <?= (int) $opt["selectedItem"]["stock"] === 0 ? "Nicht verfügbar" : "In den Warenkorb" ?>
        </a>
    <?php else: ?>
        <p class="mb-0" data-test="variant_none">Zurzeit nicht verfügbar.</p>
    <?php endif; ?>
</div>
