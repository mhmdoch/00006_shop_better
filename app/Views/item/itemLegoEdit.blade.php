@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <p class="brand-kicker mb-1">LEGO Variante</p>
                <h1 class="h2 mb-2"><?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?></h1>
                <p class="text-muted mb-0">Produkt ID: <?= e($opt["catalog"]["id"]) ?> | Varianten ID: <?= e($opt["item"]["id"]) ?> </p>
            </div>

            <div class="bg-box rounded p-4 mb-4">
                <h5>Variantendaten:</h5>
                <hr>
                <div id="edit_item_lego"></div>
            </div>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4 mb-4">
                <h5>Produkt</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Marke</span>
                    <span><?= e($opt["catalog"]["brand_name"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Modell</span>
                    <span><?= e($opt["catalog"]["name"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Produkt ID:</span>
                    <span><?= e($opt["catalog"]["id"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Varianten ID:</span>
                    <span><?= e($opt["item"]["id"]) ?></span>
                </div>
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {

            var item_lego_edit_form = Z.Forms.create({
                dom: "edit_item_lego"
            });
            item_lego_edit_form.createField({
                name: "sku",
                type: "text",
                text: "Artikelnummer",
                value: <?= json_encode($opt["item"]["sku"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "name",
                type: "text",
                text: "Name",
                value: <?= json_encode($opt["item"]["name"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "description",
                type: "textarea",
                text: "Beschreibung",
                value: <?= json_encode($opt["item"]["description"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "set_number",
                type: "text",
                text: "Setnummer",
                value: <?= json_encode($opt["item"]["set_number"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "theme",
                type: "text",
                text: "Thema",
                value: <?= json_encode($opt["item"]["theme"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "piece_count",
                type: "number",
                text: "Teileanzahl",
                value: <?= json_encode($opt["item"]["piece_count"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "release_date",
                type: "date",
                text: "Erscheinungsdatum",
                value: <?= json_encode($opt["item"]["release_date"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "price",
                type: "number",
                text: "Preis",
                value: <?= json_encode($opt["item"]["price"] ?? "") ?>,
                required: true
            });
            item_lego_edit_form.createField({
                name: "stock",
                type: "number",
                text: "Bestand",
                value: <?= json_encode($opt["item"]["stock"] ?? "") ?>,
                required: true
            });
            // The stock the admin saw, so a change made by an order in the meantime is not overwritten
            item_lego_edit_form.createField({
                name: "stock_before",
                type: "hidden",
                value: <?= json_encode((string) ($opt["item"]["stock"] ?? "")) ?>
            });
            item_lego_edit_form.buttonSubmit.textContent = "Speichern";
        });
    </script>
@endsection
