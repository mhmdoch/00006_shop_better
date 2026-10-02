@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <p class="brand-kicker mb-1">Erstellen</p>
                <h1 class="h2 mb-2">Neues Produkt</h1>
            </div>

            <div class="bg-box rounded p-4 mb-4">
                <h5>Produktdaten:</h5>
                <hr>
                <div id="create_catalog"></div>
            </div>
        </main>



    <script>
        $(document).ready(function() {

            var catalog_create_form = Z.Forms.create({
                dom: "create_catalog"
            });
            catalog_create_form.createField({
                name: "brand_id",
                type: "select",
                text: "Marke",
                food: <?= json_encode($opt["brands"]) ?>.map((brand) => ({
                    text: brand.name,
                    value: brand.id,
                })),
                required: true
            });
            catalog_create_form.createField({
                name: "name",
                type: "text",
                text: "Name",
                required: true
            });
            catalog_create_form.createField({
                name: "description",
                type: "textarea",
                text: "Description",
                required: true
            });
            catalog_create_form.createField({
                name: "itemable_type",
                type: "select",
                text: "Kategorie",
                food: <?= json_encode($opt["itemableTypes"]) ?>,
                required: true
            });
            catalog_create_form.createField({
                name: "gender",
                type: "select",
                text: "Geschlecht",
                food: <?= json_encode($opt["genders"]) ?>,
                required: false
            });
            catalog_create_form.createField({
                name: "active",
                type: "select",
                text: "Active",
                food: <?= json_encode($opt["isActive"]) ?>,
                value: "1",
                required: true
            });
            catalog_create_form.createField({
                name: "titlethumb",
                type: "file",
                text: "Bild",
                required: true
            });
            catalog_create_form.buttonSubmit.innerHTML = "Speichern";
            catalog_create_form.saveHook = (res) => {
                catalog_create_form.reset();
            };

        });
    </script>
@endsection

