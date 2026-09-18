@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4">
                <h1 class="h3 mb-0">Bestellung <?= e($opt["order"]["order_number"]) ?></h1>
            </div>

            <x-orderitemlist :orderedItems="$opt['orderItems']" :totalSum="$opt['totalSum']" :taxPot="$opt['taxPot']" :root="$opt['root']"/>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4">
                <h5>Übersicht</h5>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Kunde</span>
                    <span><?= e($opt["order"]["email"] ?? "Gast") ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Status</span>
                    <span><?= e($opt["order"]["status"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Bestellt am</span>
                    <span><?= e(date("d.m.Y H:i", strtotime($opt["order"]["created"]))) ?></span>
                </div>

                <?php if ($opt["canEditStatus"]): ?>
                    <hr>
                    <div id="order_status_form"></div>

                    <script>
                        $(document).ready(function() {
                            var order_status_form = Z.Forms.create({
                                dom: "order_status_form",
                                hidehints: true
                            });

                            order_status_form.createField({
                                name: "status",
                                type: "select",
                                text: "Status ändern",
                                value: <?= json_encode($opt["order"]["status"]) ?>,
                                food: <?= $opt["statuses"] ?>.map((status) => ({
                                    text: status
                                })),
                                required: true
                            });

                            order_status_form.buttonSubmit.innerHTML = "Status speichern";
                            order_status_form.saveHook = () => {
                                window.location.reload();
                            };
                        });
                    </script>
                <?php endif; ?>
            </div>

            <div class="bg-box rounded p-4 mt-4">
                <h5>Lieferadresse</h5>
                <hr>
                <div><?= e($opt["order"]["recipient"]) ?></div>
                <div><?= e($opt["order"]["address_line_1"]) ?></div>
                <?php if (!empty($opt["order"]["address_line_2"])): ?>
                    <div><?= e($opt["order"]["address_line_2"]) ?></div>
                <?php endif; ?>
                <div><?= e($opt["order"]["postal_code"]) ?> <?= e($opt["order"]["city"]) ?></div>
                <div><?= e($opt["order"]["country"]) ?></div>
            </div>
        </aside>
    </div>
@endsection
