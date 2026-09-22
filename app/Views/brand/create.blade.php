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
                required: true
            });
            brand_create_form.createField({
                name: "website",
                type: "text",
                text: "Webseite",
                required: false
            });

            brand_create_form.saveHook = (res) => {
                brand_create_form.reset();
            };

        });
    </script>
@endsection
