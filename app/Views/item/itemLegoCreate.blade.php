@extends($layout)

@section("content")
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/catalog">Katalog</a></li>
            <li class="breadcrumb-item"><a href="/catalog/show/<?= e($opt["catalog"]["id"]) ?>"><?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">LEGO-Set hinzufügen</li>
        </ol>
    </nav>


    <div id="create_item_lego"></div>

    <script>
        $(document).ready(function() {

            var item_lego_create_form = Z.Forms.create({
                dom: "create_item_lego"
            });
            item_lego_create_form.createField({
                name: "sku",
                type: "text",
                text: "Artikelnummer",
                required: true
            });
            item_lego_create_form.createField({
                name: "name",
                type: "text",
                text: "Name",
                required: true
            });
            item_lego_create_form.createField({
                name: "description",
                type: "textarea",
                text: "Beschreibung",
                required: true
            });
            item_lego_create_form.createField({
                name: "set_number",
                type: "text",
                text: "Setnummer",
                required: true
            });
            item_lego_create_form.createField({
                name: "theme",
                type: "text",
                text: "Thema",
                required: true
            });
            item_lego_create_form.createField({
                name: "piece_count",
                type: "number",
                text: "Teileanzahl",
                required: true
            });
            item_lego_create_form.createField({
                name: "release_date",
                type: "date",
                text: "Erscheinungsdatum",
                required: true
            });
            item_lego_create_form.createField({
                name: "price",
                type: "number",
                text: "Preis",
                required: true
            });
            item_lego_create_form.createField({
                name: "stock",
                type: "number",
                text: "Bestand",
                required: true
            });

            item_lego_create_form.saveHook = (res) => {
                item_lego_create_form.reset();
            };

        });
    </script>
@endsection
