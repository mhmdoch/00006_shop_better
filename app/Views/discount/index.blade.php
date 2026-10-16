@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8" id="discountIndexContainer">
            <div class="bg-box rounded p-4">
                <h3>Rabattcodes - Übersicht</h3>
            </div>

            <div class="bg-box rounded p-4 mt-4">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th class="text-right">Betrag</th>
                                <th class="text-right" title="Mindestbestellwert">MBW</th>
                                <th>Aktiv</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($opt["discounts"])): ?>
                                <tr>
                                    <td colspan="5">Keine Rabattcodes vorhanden.</td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($opt["discounts"] as $discount): ?>
                                <tr>
                                    <td>
                                        <a href="<?= e($opt["root"]) ?>discount/show/<?= e($discount["id"]) ?>" data-test="discount">
                                            <?= e($discount["code"]) ?>
                                        </a>
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <?= e(number_format((float) $discount["value"], 2, ",", ".")) ?>
                                        <?= $discount["type"] === "percent" ? "%" : "€" ?>
                                    </td>
                                    <td class="text-right text-nowrap">
                                        <?= e(number_format((float) $discount["min_total"], 2, ",", ".")) ?> €
                                    </td>
                                    <td><?= $discount["active"] ? "Ja" : "Nein" ?></td>
                                    <td class="text-right text-nowrap">
                                        <a href="<?= e($opt["root"]) ?>discount/edit/<?= e($discount["id"]) ?>" class="bi bi-wrench" title="Status ändern"></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4">
                <h5>Verwaltung</h5>
                <hr>
                <div class="mt-2"> - <a href="<?= e($opt["root"]) ?>discount/create">Hinzufügen</a></div>
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {
            $("#discountIndexContainer").on("click", ".delete-discount", function(event) {
                event.preventDefault();

                if (!confirm("Rabattcode wirklich deaktivieren?")) {
                    return;
                }

                var id = $(this).data("id");

                Z.Request.action('delete-discount', {
                    discountId: id
                }, (res) => {
                    if (res.result == 'success') {
                        location.reload();
                        return;
                    }
                    alert("An error occurred");
                });
            });
        });
    </script>
@endsection
