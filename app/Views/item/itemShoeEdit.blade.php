@extends($layout)

@section("content")
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/catalog">Katalog</a></li>
            <li class="breadcrumb-item"><a href="/catalog/show/<?= e($opt["catalog"]["id"]) ?>"><?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Variante bearbeiten</li>
        </ol>
    </nav>


    <div id="edit_item_shoe"></div>

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

        });
    </script>
@endsection
