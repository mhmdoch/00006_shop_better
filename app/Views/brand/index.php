<?php return ["body" => function ($opt) { ?>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Marken</li>
        </ol>
    </nav>

    <br>

    <div class="row">
        <main class="col-lg-8" id="brandIndexContainer">
            <div class="bg-box rounded p-4">
                <h3>Marken - Übersicht</h3>
            </div>
            <?php foreach ($opt["brands"] as $brand) { ?>
                <div class="bg-box rounded p-4 mt-4">
                    <a href="/brand/show/<?= e($brand["id"]) ?>"><?= $brand["name"] ?></a>
                    <?php if ($opt["user"]->checkPermission("brand.edit")): ?>
                        <a href="/brand/edit/<?= e($brand["id"]) ?>" class="bi bi-wrench" data-id="<?= e($brand["id"]) ?>" title="editieren"></a>
                    <?php endif; ?>
                    <?php if ($opt["user"]->checkPermission("brand.delete")): ?>
                        <?php if (! e($brand["active"] === 0)): ?>
                            <a href="#" class="delete-brand bi bi-trash3" data-id="<?= e($brand["id"]) ?>" title="löschen"></a>
                        <?php else: ?>

                            <?= (e($brand["active"]) == true) ? "<span style='color:green;font-weight:bold;'>aktiv</span>" : "<span style='color:darkred'>gelöscht</span>" ?>

                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </main>

        <aside class="col-lg-4">
            <?php if ($opt["user"]->checkPermission("brand.create")): ?>
                <div class="bg-box rounded p-4 mb-4">
                    <h5>Verwaltung</h5>
                    <hr>
                    <div> - <a href="/brand/">Index</a></div>
                    <div> - <a href="/brand/inactive">Inaktive</a></div>
                    <div class="mt-2"> - <a href="/brand/create">Hinzufügen</a></div>
                </div>
            <? endif; ?>

            <div class="bg-box rounded p-4">
                A–Z-Filter
            </div>
        </aside>
    </div>

    <script>
        $(document).ready(function() {
            $("#brandIndexContainer").on("click", ".delete-brand", function() {
                // der Link wird hier eh nicht ausgeführt, aber damit verhindere ich hier an der Stelle
                // dass der Cursor wieder zum Seitenanfang geht
                event.preventDefault();

                if (!confirm("ACHTUNG: Marke wirklich löschen? Dies hat Auswirkungen auf zugehörige Produkte und deren Varianten.")) {
                    return;
                }

                var id = $(this).data("id");

                Z.Request.action('delete-brand', {
                    brandId: id
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

<?php }]; ?>