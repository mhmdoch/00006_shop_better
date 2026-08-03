<?php return ["body" => function ($opt) { ?>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Marken</li>
        </ol>
    </nav>

    <br>

    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4">
                <h3>Marken - Übersicht</h3>
            </div>
            <?php foreach ($opt["brands"] as $brand) { ?>
                <div class="bg-box rounded p-4 mt-4">
                    <a href="/brand/show/<?= e($brand["id"]) ?>"><?= $brand["name"] ?></a> <a href="/brand/edit/<?= e($brand["id"]) ?>">Hinzufügen</a> <a class="bi bi-plus-circle"></a><br>
                </div>
            <?php } ?>
        </main>

        <aside class="col-lg-4">
            <?php if ($opt["user"]->checkPermission("brand.create") || $opt["user"]->checkPermission("brand.edit")): ?>
                <div class="bg-box rounded p-4 mb-4">
                    <h5>Verwaltung</h5>
                    <hr>
                    <div> - <a href="/brand/create">Hinzufügen</a></div>
                </div>
            <? endif; ?>

            <div class="bg-box rounded p-4">
                A–Z-Filter
            </div>
        </aside>
    </div>
<?php }]; ?>