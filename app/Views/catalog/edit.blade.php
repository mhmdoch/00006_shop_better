@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <p class="brand-kicker mb-1"><?= e($opt["catalog"]["brand_name"]) ?></p>
                <h1 class="h2 mb-2"><?= e($opt["catalog"]["name"]) ?></h1>
            </div>

            <div class="bg-box rounded p-4 mb-4">
                <h5>Produktdaten:</h5>
                <hr>
                <div id="create_catalog"></div>
            </div>

            <div class="bg-box rounded p-4 mb-4">
                <h5>Weitere Bilder:</h5>
                <hr>
                <div class="row" data-test="catalog_images">
                    <?php foreach ($opt["images"] as $image): ?>
                        <div class="col-6 col-md-4 mb-3">
                            <img src="<?php $opt["generateResourceLink"]("uploads/thumb_{$image["reference"]}.jpg"); ?>" class="img-fluid rounded" alt="Katalogbild">
                            <a href="#" class="delete-catalogImage bi bi-trash3" data-id="<?= e($image["id"]) ?>" data-test="delete_catalog_image" title="Bild entfernen" aria-label="Bild entfernen"></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="upload_catalog_image"></div>
            </div>
        </main>



    <aside class="col-lg-4">
        <div class="bg-box rounded p-4">
            <div class="d-flex justify-content-between">
                <span></span>
                <span></span>
            </div>

            <div class="d-flex justify-content-between mt-2">

                <span>

                <?php if (isset($opt["titlethumb"]["reference"])) { ?>
                    <img src="<?php $opt["generateResourceLink"]("uploads/thumb_{$opt["titlethumb"]["reference"]}.{$opt["titlethumb"]["extension"]}"); ?>" class="card-img-top">
                <?php } else { ?>
                    <img src="<?php $opt["generateResourceLink"]("assets/img/{$opt["catalog"]["itemable_type"]}.png"); ?>" class="card-img-top">
                <?php } ?>
                </span>
            </div>

        </div>
    </aside>
    </div>


    
    <script>
        $(document).ready(function() {
            var catalog_create_form = Z.Forms.create({
                dom: "create_catalog"
            });
            catalog_create_form.createField({
                name: "brand_id",
                type: "select",
                text: "Marke",
                value: <?= $catalog["brand_id"] ?>,
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
                value: <?= json_encode($catalog["name"]) ?>,
                required: true
            });
            catalog_create_form.createField({
                name: "description",
                type: "textarea",
                text: "Description",
                value: <?= json_encode($catalog["description"]) ?>,
                required: true
            });
            catalog_create_form.createField({
                name: "itemable_type",
                type: "select",
                text: "Kategorie",
                value: <?= json_encode($catalog["itemable_type"]) ?>,
                food: <?= json_encode($opt["itemableTypes"]) ?>,
                required: true
            });
            catalog_create_form.createField({
                name: "gender",
                type: "select",
                text: "Geschlecht",
                value: <?= json_encode($catalog["gender"]) ?>,
                food: <?= json_encode($opt["genders"]) ?>,
                required: false
            });
            catalog_create_form.createField({
                name: "active",
                type: "select",
                text: "Active",
                food: <?= json_encode($opt["isActive"]) ?>,
                value: <?= json_encode($catalog["active"]) ?>,
                required: true
            });
            var upload_image_form = Z.Forms.create({
                dom: "upload_catalog_image"
            });
            upload_image_form.createField({
                name: "image",
                type: "file",
                text: "Bild hinzufügen",
                required: true
            });
            upload_image_form.buttonSubmit.innerHTML = "Bild hochladen";
            upload_image_form.saveHook = () => location.reload();

            $(".delete-catalogImage").on("click", function (event) {
                event.preventDefault();
                Z.Request.action("delete-catalogImage", {imageId: $(this).data("id")}, (res) => {
                    if (res.result === "success") location.reload();
                });
            });

            catalog_create_form.createField({
                name: "titlethumb",
                type: "file",
                text: "Bild",
                value: <?= json_encode($catalog["titlethumb"]) ?>
            });
        });
    </script>
@endsection



