@extends($layout)

@section("content")
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/brand">Marken</a></li>

            <li class="breadcrumb-item active" aria-current="page">Hinzufügen</li>
        </ol>
    </nav>


    <div id="create_brand"></div>

    <script>
        $(document).ready(function() {

            var brand_create_form = Z.Forms.create({
                dom: "create_brand"
            });
            brand_create_form.createField({
                name: "name",
                type: "text",
                text: "Name",
                value: <?= json_encode($opt["brand"]["name"] ?? "") ?>,
                required: true
            });
            brand_create_form.createField({
                name: "website",
                type: "text",
                text: "Webseite",
                value: <?= json_encode($opt["brand"]["website"] ?? "") ?>,
                required: false
            });



        });
    </script>
@endsection
