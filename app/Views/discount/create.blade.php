@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h3>Rabattcode hinzufügen</h3>
        <hr>
        <div id="create_discount"></div>
    </div>

    <script>
        $(document).ready(function() {
            var discount_create_form = Z.Forms.create({
                dom: "create_discount"
            });
            discount_create_form.createField({
                name: "code",
                type: "text",
                text: "Code",
                required: true
            });
            discount_create_form.createField({
                name: "type",
                type: "select",
                text: "Rabattart",
                food: [
                    { value: "percent", text: "Prozent" },
                    { value: "fixed", text: "Festbetrag (€)" },
                ],
                value: "percent",
                required: true
            });
            discount_create_form.createField({
                name: "value",
                type: "number",
                text: "Rabattwert (% oder €)",
                attributes: { min: "0.01", step: "0.01" },
                required: true
            });
            discount_create_form.createField({
                name: "min_total",
                type: "number",
                text: "Mindestbestellwert (€)",
                attributes: { min: "0", step: "0.01" },
                value: "0.00",
                required: true
            });
            discount_create_form.createField({
                name: "active",
                type: "select",
                text: "Status",
                food: [
                    { value: "1", text: "Aktiv" },
                    { value: "0", text: "Inaktiv" },
                ],
                value: "1",
                required: true
            });

            discount_create_form.saveHook = (res) => {
                discount_create_form.reset();
            };
        });
    </script>
@endsection
