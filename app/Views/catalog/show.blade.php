@extends($layout)

@section("content")



<div class="row">
    <main class="col-lg-8" id="brandIndexContainer">
        <div class="bg-box rounded p-4">
            <h3>
                <?= $opt["catalog"]["brand_name"] ?> <?= $opt["catalog"]["name"] ?>
                <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.delete")): ?>
                    <a href="<?php echo $opt["root"]; ?>brand/edit/<?= $opt["catalog"]["id"] ?>" class="bi bi-wrench" data-id="" title="editieren"></a> <a href="#" class="delete-brand bi bi-trash3" data-id="" title="löschen"></a>
                <?php endif; ?>
            </h3>
        </div>

        <div class="bg-box rounded p-4 mt-4">
            <img src="<?php $opt["generateResourceLink"]("assets/img/{$opt["catalog"]["itemable_type"]}.png"); ?>" class="card-img-top">
        </div>

        <?php if ($opt["catalog"]["itemable_type"] === "shoe"): ?>
            <x-itemShoeSelector :opt="$opt" />
        <?php endif; ?>

        <?php if ($opt["user"]->checkPermission("catalog.edit") || $opt["user"]->checkPermission("catalog.delete")): ?>
        <div class="bg-box rounded p-4 mt-4">
            <h4>Varianten:</h4>

            <div class="table-responsive">
                <?php if ($opt["catalog"]["itemable_type"] === "shoe") { ?>
                    <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="w-5">Farbe</th>
                                    <th style="width:5%">Größe</th>
                                    <th style="width:15%">Preis</th>
                                    <th style="width:5%">Anzahl</th>
                                    <th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody class="cartItemList">
                                <?php foreach ($opt["items"] as $item) { ?>
                                    <tr>
                                        <td><?= e($item["color"]) ?></td>
                                        <td class="text-right"><?= e($item["size"]) ?></td>
                                        <td class="text-right"><?= e($item["price"]) ?> €</td>
                                        <td class="text-right"><?= e($item["stock"]) ?></td>
                                        <td class="text-right"><a href="<?php echo $opt["root"]; ?>item/itemShoeEdit/<?= e($item["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                <?php } ?>
            </div>
        <?php endif; ?>
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
                            <a href="<?php echo $opt["root"]; ?>item/itemShoeCreate/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                        <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>
                            <a href="<?php echo $opt["root"]; ?>item/itemLegoCreate/<?= e($opt["catalog"]["id"]) ?>">Variante hinzufügen</a>
                        <?php } ?></span>
                    <span></span>
                </div>
            <?php endif; ?>

        </div>
    </aside>
</div>

@endsection
