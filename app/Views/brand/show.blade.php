@extends($layout)

@section("content")


    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4">
                <p class="brand-kicker mb-1">Marke</p>
                <h1 class="h2 mb-2"><?= e($opt["brand"]["name"]) ?></h1>
            </div>
            <?php foreach ($opt["catalogs"] as $catalog) { ?>

                <div class="bg-box rounded p-4 mt-4">
                    <div><?= e($catalog["name"]) ?></div>
                    <div><?= e($catalog["description"]) ?></div>
                </div>
            <?php } ?>



<?php foreach ($opt["catalogs"] as $catalog) { ?>
    <x-cataloglist :catalog="$catalog" :opt="$opt"></x-cataloglist>
<?php } ?>

        </main>
        <aside class="col-lg-4">
            <div class="bg-box rounded p-4 mb-4">
                <h5>Übersicht</h5>
                <hr>
                <?php if ($opt["user"]->checkPermission("brand.edit") || $opt["user"]->checkPermission("brand.create")): ?>
                    <div class="d-flex justify-content-between">
                        <span>Status</span>
                        <span><?= (e($opt["brand"]["active"]) == true) ? "<span style='color:green;font-weight:bold;'>aktiv</span>" : "<span style='color:darkred'>gelöscht</span>" ?></span>
                    </div>
                <? endif; ?>

                <div class="d-flex justify-content-between">
                    <span>Produkte</span>
                    <span><?= count($opt["catalogs"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Varianten</span>
                    <span><?= count($opt["items"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Webseite</span>
                    <span>
                        <?php if (filter_var($opt["brand"]["website"], FILTER_VALIDATE_URL) !== false) { ?>

                            <a href="<?= e($opt["brand"]["website"]) ?>" target="_blank">Link</a>
                        <?php } else { ?> - <?php } ?>
                    </span>
                </div>
            </div>
            <?php if ($opt["user"]->checkPermission("delete.edit")): ?>
                <div class="bg-box rounded p-4">
                    <h5>Verlauf</h5>
                    <hr>

                    <?php foreach ($opt["logActive"] as $log) { ?>
                        <div class="d-flex justify-content-between">
                            <span><?= $log["date"] ?></span>
                            <span><?= $log["action"] ?></span>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </aside>
    </div>
@endsection
