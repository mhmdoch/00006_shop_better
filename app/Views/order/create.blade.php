@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Bestellung abschließen</h1>
    </div>

    <div class="row">
        <main class="col-lg-8">
            <x-orderitemlist :orderedItems="$opt['orderItems']" :totalSum="$opt['totalSum']" :taxPot="$opt['taxPot']" :root="$opt['root']" :subtotal="$opt['subtotal']" :discountAmount="$opt['discountAmount']" :discountCode="$opt['discountCode']" />
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4 mt-4">
                <h5>Lieferadresse</h5>
                <hr>
                <div id="create_order" data-test="order-address-form"></div>
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {
            var order_create_form = Z.Forms.create({
                dom: "create_order"
            });
            order_create_form.createField({
                name: "email",
                type: "email",
                text: "E-Mail",
                required: true,
                <?php if ($opt["user"]->isLoggedIn) { ?>
                    value: <?= json_encode(user()->fields["email"]); ?>,
                <?php } else { ?>
                    value: "",
                <?php } ?>
            });
            order_create_form.createField({
                name: "recipient",
                type: "text",
                text: "Empfänger",
                required: true
            });
            order_create_form.createField({
                name: "address_line_1",
                type: "text",
                text: "Straße und Hausnummer",
                required: true
            });
            order_create_form.createField({
                name: "address_line_2",
                type: "text",
                text: "Adresszusatz",
                required: false
            });
            order_create_form.createField({
                name: "postal_code",
                type: "text",
                text: "Postleitzahl",
                required: true
            });
            order_create_form.createField({
                name: "city",
                type: "text",
                text: "Ort",
                required: true
            });
            order_create_form.createField({
                name: "country",
                type: "text",
                text: "Land",
                value: "Deutschland",
                required: true
            });

            order_create_form.buttonSubmit.innerHTML = "Bestellung abschließen";
            order_create_form.saveHook = (res) => {
                if (res.cartChanged) {
                    window.location.href = <?= json_encode($opt["root"] . "cart", JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
                    return;
                }
                window.location.href = <?= json_encode($opt["root"] . "order/show/", JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?> + res.orderId;
            };
        });
    </script>
@endsection
