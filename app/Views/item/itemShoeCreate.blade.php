@extends($layout)

@section("content")



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
                name: "taxrate",
                type: "number",
                text: "Steuersatz",
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
@endsection
