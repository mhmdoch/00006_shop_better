<?php return ["body" => function ($opt) { ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/catalog">Katalog</a></li>
            <li class="breadcrumb-item"><a href="/catalog/show/<?= e($opt["catalog"]["id"]) ?>"><?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Schuh hinzufügen</li>
        </ol>
    </nav>


    <div id="create_item_shoe"></div>

    <script>
        $(document).ready(function() {

            var item_shoe_create_form = Z.Forms.create({
                dom: "create_item_shoe"
            });
            item_shoe_create_form.createField({
                name: "sku",
                type: "text",
                text: "Artikelnummer",
                required: true
            });
            item_shoe_create_form.createField({
                name: "size",
                type: "text",
                text: "Größe",
                required: true
            });
            item_shoe_create_form.createField({
                name: "color",
                type: "text",
                text: "Farbe",
                required: true
            });
            item_shoe_create_form.createField({
                name: "price",
                type: "number",
                text: "Preis",
                required: true
            });
            item_shoe_create_form.createField({
                name: "stock",
                type: "number",
                text: "Bestand",
                required: true
            });

            item_shoe_create_form.saveHook = (res) => {
                item_shoe_create_form.reset();
            };

        });
    </script>

<?php }]; ?>
