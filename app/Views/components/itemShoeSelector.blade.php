@props(["opt"])

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

        <a
            href="<?= (int) $opt["selectedItem"]["stock"] === 0 ? "#" : $opt["root"] . "cart/add/" . rawurlencode($opt["selectedItem"]["id"]) ?>"
            class="btn cart-button btn-block mt-3 <?= (int) $opt["selectedItem"]["stock"] === 0 ? "disabled" : "" ?>"
            data-item-id="<?= e($opt["selectedItem"]["id"]) ?>"
            <?= (int) $opt["selectedItem"]["stock"] === 0 ? 'aria-disabled="true"' : "" ?>
        >
            <?= (int) $opt["selectedItem"]["stock"] === 0 ? "Nicht verfügbar" : "In den Warenkorb" ?>
        </a>
    <?php endif; ?>
</div>
