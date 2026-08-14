<?php return ["body" => function ($opt) { ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/catalog">Katalog</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $opt["catalog"]["brand_name"] ?> <?= $opt["catalog"]["name"] ?></li>
        </ol>
    </nav>

    <br>

    <div class="row">
        <main class="col-lg-8" id="brandIndexContainer">
            <div class="bg-box rounded p-4">
                <h3><?= $opt["catalog"]["brand_name"] ?> <?= $opt["catalog"]["name"] ?></h3>
            </div>

            <div class="bg-box rounded p-4 mt-4">
                <img src="<?php $opt["generateResourceLink"]("assets/img/{$opt["catalog"]["itemable_type"]}.png"); ?>" class="card-img-top">
            </div>
            <div class="bg-box rounded p-4 mt-4">
                <a href="/brand/show/"></a>
                <a href="/brand/edit/" class="bi bi-wrench" data-id="" title="editieren"></a> <a href="#" class="delete-brand bi bi-trash3" data-id="" title="löschen"></a>
            </div>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4">
                <h5>Übersicht</h5>
                <hr>
                <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.create")): ?>
                    <div class="d-flex justify-content-between">
                        <span>Status</span>
                        <span><?= (e($opt["catalog"]["active"]) == true) ? "<span style='color:green;font-weight:bold;'>aktiv</span>" : "<span style='color:darkred'>gelöscht</span>" ?></span>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between">
                    <span>Varianten</span>
                    <span><?= count($opt["items"]) ?></span>
                </div>

                <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.create")): ?>
                    <div class="d-flex justify-content-between mt-2">
                        <span> <?php if ($opt["catalog"]["itemable_type"] === "shoe") { ?>
                                <a href="/item/itemShoe_create/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                            <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>
                                <a href="/item/itemLegoCreate/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                            <?php } ?></span>
                        <span></span>
                    </div>
                <?php endif; ?>

            </div>
        </aside>
    </div>

    Data from a model:
    <ul>
        <li>
            <?= $opt["catalog"]["name"] ?> </li>

        <?php foreach ($opt["items"] as $item) { ?>
            <li>
                <?= e($item["color"]) ?> <?= e($item["size"]) ?> <?= e($item["price"]) ?>
                <?php if ($opt["catalog"]["itemable_type"] === "shoe") { ?>
                    <a href="/item/itemShoeEdit/<?= e($item["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a>
                <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>

                <?php } ?>
            </li>
        <?php } ?>
    </ul>
<?php }]; ?>