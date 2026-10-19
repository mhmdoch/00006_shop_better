@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h3>Status für <?= e($opt["discount"]["code"]) ?> ändern</h3>
        <hr>
        <p>
            Rabatt: <?= e(number_format((float) $opt["discount"]["value"], 2, ",", ".")) ?>
            <?= $opt["discount"]["type"] === "percent" ? "%" : "€" ?><br>
            Mindestbestellwert: <?= e(\App\Helper\AppHelper::price($opt["discount"]["min_total"])) ?>
        </p>
        <div id="edit_discount"></div>
    </div>

    <script>
        $(document).ready(function() {
            var discount_edit_form = Z.Forms.create({
                dom: "edit_discount"
            });
            discount_edit_form.createField({
                name: "active",
                type: "select",
                text: "Status",
                food: [
                    { value: "1", text: "Aktiv" },
                    { value: "0", text: "Inaktiv" },
                ],
                value: <?= json_encode($opt["discount"]["active"], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
                required: true
            });
        });
    </script>
@endsection
