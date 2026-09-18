@extends($layout)

@section("content")
    <div class="bg-box rounded p-4">
        <h1 class="h3 mb-0">Bestellung abschließen</h1>
    </div>

    <div class="row">
        <main class="col-lg-8">
            <x-orderitemlist :orderedItems="$opt['orderItems']" :totalSum="$opt['totalSum']" :taxPot="$opt['taxPot']" :root="$opt['root']" />
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4 mt-4">
                <h5>Lieferadresse</h5>
                <hr>
                <div id="create_order"></div>
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {
            var order_create_form = Z.Forms.create({
                dom: "create_order"
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
                window.location.href = "<?= $opt["root"] ?>order/show/" + res.orderId;
            };
        });
    </script>
@endsection
