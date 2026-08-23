@extends($layout)

@section("content")
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
        });
    </script>
@endsection
