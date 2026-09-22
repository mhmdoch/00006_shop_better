@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <p class="brand-kicker mb-1">Schuhvariante</p>
                <h1 class="h2 mb-2"><?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?></h1>
                <p class="text-muted mb-0">Produkt ID: <?= e($opt["catalog"]["id"]) ?> | Varianten ID: <?= e($opt["item"]["id"]) ?> </p>
            </div>

            <div class="bg-box rounded p-4 mb-4">
                <h5>Variantendaten:</h5>
                <hr>
                <div id="edit_item_shoe"></div>
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

            var item_shoe_edit_form = Z.Forms.create({
                dom: "edit_item_shoe"
            });
            item_shoe_edit_form.createField({
                name: "sku",
                type: "text",
                text: "Artikelnummer",
                value: <?= json_encode($opt["item"]["sku"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.createField({
                name: "size",
                type: "text",
                text: "Größe",
                value: <?= json_encode($opt["item"]["size"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.createField({
                name: "color",
                type: "text",
                text: "Farbe",
                value: <?= json_encode($opt["item"]["color"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.createField({
                name: "taxrate",
                type: "number",
                text: "Steuersatz (%)",
                value: <?= json_encode($opt["item"]["taxrate"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.createField({
                name: "price",
                type: "number",
                text: "Preis",
                value: <?= json_encode($opt["item"]["price"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.createField({
                name: "stock",
                type: "number",
                text: "Bestand",
                value: <?= json_encode($opt["item"]["stock"] ?? "") ?>,
                required: true
            });
            item_shoe_edit_form.buttonSubmit.textContent = "Speichern";
        });
    </script>
@endsection
