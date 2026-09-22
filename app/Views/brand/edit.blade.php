@extends($layout)

@section("content")



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
