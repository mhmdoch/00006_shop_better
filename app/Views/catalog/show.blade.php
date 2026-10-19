@extends($layout)

@section("content")



<div class="row">
    <main class="col-lg-8" id="brandIndexContainer">
        <div class="bg-box rounded p-4">
            <h3>
                <?= e($opt["catalog"]["brand_name"]) ?> <?= e($opt["catalog"]["name"]) ?>
                <?php if ($opt["user"]->checkPermission("catalog.manage")): ?>
                    <a href="<?php echo $opt["root"]; ?>catalog/edit/<?= e($opt["catalog"]["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a> <a href="#" class="delete-brand bi bi-trash3" data-id="" title="löschen"></a>
                <?php endif; ?>
            </h3>
        </div>

        <div class="bg-box rounded p-4 mt-4">
            <?php if (isset($opt["titlethumb"]["reference"])) { ?>
                <img src="<?php $opt["generateResourceLink"]("uploads/{$opt["titlethumb"]["reference"]}.{$opt["titlethumb"]["extension"]}"); ?>" class="card-img-top">
            <?php } else { ?>
                <img src="<?php $opt["generateResourceLink"]("assets/img/{$opt["catalog"]["itemable_type"]}.png"); ?>" class="card-img-top">
            <?php } ?>

            <?php if (!empty(trim($opt["catalog"]["description"] ?? ""))): ?>
                <p class="mt-4 mb-0" data-test="catalog_description"><?= nl2br(e($opt["catalog"]["description"])) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($opt["catalog"]["itemable_type"] === "shoe"): ?>
            <div id="itemShoeSelectorContainer">
                <x-itemShoeSelector :opt="$opt" />
            </div>

            <script>
                $('#itemShoeSelectorContainer').on('click', 'a[data-test="variant_size"], a[data-test="variant_size_all"], a[data-test="variant_color"]', function (event) {
                    event.preventDefault();

                    var url = this.href;
                    $('#itemShoeSelectorContainer').load(url + ' #itemShoeSelectorContainer > *');
                    window.history.pushState({}, "", url);
                });
            </script>
        <?php elseif ($opt["catalog"]["itemable_type"] === "lego"): ?>
            <x-itemLegoSelector :opt="$opt" />
        <?php endif; ?>

        <div id="catalogRatingsContainer" class="bg-box rounded p-4 mt-4" data-test="catalog_ratings">
            <h4>Bewertungen</h4>

            <?php if ($opt["ratingSum"]["rating_count"] > 0): ?>
                <?php
                    $averageStars = $opt["ratingSum"]["average_stars"];
                    $roundedStars = bcdiv(bcadd(bcmul($averageStars, '2', 1), '0.5', 0), '2', 1);
                ?>
                <div class="d-flex align-items-center flex-wrap mb-3" data-test="catalog_rating_sum">
                    <span class="text-warning mr-2">
                        <?php for ($star = 1; $star <= 5; $star++): ?>
                            <i class="bi <?= bccomp($star, $roundedStars, 1) <= 0 ? 'bi-star-fill' : (bccomp(bcsub($star, '0.5', 1), $roundedStars, 1) <= 0 ? 'bi-star-half' : 'bi-star') ?>"></i>
                        <?php endfor; ?>
                    </span>
                    <strong class="mr-2"><?= e(str_replace('.', ',', bcadd($averageStars, '0.05', 1))) ?> / 5</strong>
                    <span class="text-muted">
                        aus <?= e($opt["ratingSum"]["rating_count"]) ?> <?= $opt["ratingSum"]["rating_count"] === 1 ? 'Bewertung' : 'Bewertungen' ?>
                    </span>
                </div>

                <?php foreach ($opt["ratings"] as $rating): ?>
                    <article class="border-top pt-3 mt-3" data-test="catalog_rating">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <span class="text-warning mr-2">
                                    <?php for ($star = 1; $star <= 5; $star++): ?>
                                        <i class="bi <?= $star <= (int) $rating['stars'] ? 'bi-star-fill' : 'bi-star' ?>" ></i>
                                    <?php endfor; ?>
                                </span>
                                <small class="text-muted"><?= e($rating["stars"]) ?> von 5</small>
                                <?php if ($opt["user"]->checkPermission("catalog.manage")): ?>
                                    <a href="#" class="delete-catalogRating bi bi-trash3 ml-2" data-id="<?= e($rating['id']) ?>" data-test="delete_catalog_rating" title="Bewertung entfernen" aria-label="Bewertung entfernen"></a>
                                <?php endif; ?>
                            </div>
                            <time class="small text-muted" datetime="<?= e(date('Y-m-d', strtotime($rating['created']))) ?>">
                                <?= e(date('d.m.Y', strtotime($rating['created']))) ?>
                            </time>
                        </div>
                        <p class="mb-0 mt-2" data-test="catalog_rating_text"><?= e($rating["review_text"]) ?></p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted mb-0" data-test="catalog_ratings_empty">Noch keine Bewertungen vorhanden.</p>
            <?php endif; ?>

            <hr>
            <?php if ((int) $opt["catalog"]["active"] !== 1): ?>
                <p class="text-muted mb-0">Dieses Produkt kann nicht mehr bewertet werden.</p>
            <?php elseif (!$opt["user"]->isLoggedIn): ?>
                <p class="mb-0"><a href="<?= e($opt['root']) ?>login">Melde dich an</a>, um eine Bewertung abzugeben.</p>
            <?php elseif ($opt["ownRating"] !== null): ?>
                <p class="text-muted mb-0" data-test="catalog_rating_already_created">Du hast dieses Produkt bereits bewertet.</p>
            <?php else: ?>
                <h5>Deine Bewertung</h5>
                <div id="create_catalog_rating" data-test="create_catalog_rating"></div>
                <script>
                    $(document).ready(function() {
                        var catalog_rating_create_form = Z.Forms.create({
                            dom: "create_catalog_rating"
                        });
                        catalog_rating_create_form.createField({
                            name: "stars",
                            type: "select",
                            text: "Sterne",
                            required: true,
                            value: "",
                            food: [
                                { value: "", text: "Sterne wählen" },
                                { value: 1, text: "1 Stern" },
                                { value: 2, text: "2 Sterne" },
                                { value: 3, text: "3 Sterne" },
                                { value: 4, text: "4 Sterne" },
                                { value: 5, text: "5 Sterne" }
                            ]
                        });
                        catalog_rating_create_form.createField({
                            name: "review_text",
                            type: "textarea",
                            text: "Bewertungstext",
                            required: true
                        });
                        catalog_rating_create_form.buttonSubmit.innerHTML = "Bewertung abgeben";
                        catalog_rating_create_form.saveHook = (res) => {
                            location.reload();
                        };
                    });
                </script>
            <?php endif; ?>
        </div>

        <?php if ($opt["user"]->checkPermission("catalog.manage")): ?>
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
                                        <td class="text-right"><?= e(\App\Helper\AppHelper::price($item["price"])) ?></td>
                                        <td class="text-right"><?= e($item["stock"]) ?></td>
                                        <td class="text-right"><a href="<?php echo $opt["root"]; ?>item/itemShoeEdit/<?= e($item["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                <?php } elseif ($opt["catalog"]["itemable_type"] === "lego") { ?>
                    <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width:10%">Setnummer</th>
                                    <th style="width:15%">Preis</th>
                                    <th style="width:5%">Anzahl</th>
                                    <th style="width:5%"></th>
                                </tr>
                            </thead>
                            <tbody class="cartItemList">
                                <?php foreach ($opt["items"] as $item) { ?>
                                    <tr>
                                        <td><?= e($item["name"]) ?></td>
                                        <td class="text-right"><?= e($item["set_number"]) ?></td>
                                        <td class="text-right"><?= e(\App\Helper\AppHelper::price($item["price"])) ?></td>
                                        <td class="text-right"><?= e($item["stock"]) ?></td>
                                        <td class="text-right"><a href="<?php echo $opt["root"]; ?>item/itemLegoEdit/<?= e($item["id"]) ?>" class="bi bi-wrench" data-id="" title="editieren"></a></td>
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
            <?php if ($opt["user"]->checkPermission("catalog.manage")): ?>
                <div class="d-flex justify-content-between">
                    <span>Status</span>
                    <span><?= (e($opt["catalog"]["active"]) == true) ? "<span style='color:green;font-weight:bold;'>aktiv</span>" : "<span style='color:darkred'>gelöscht</span>" ?></span>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between">
                <span>Varianten</span>
                <span><?= count($opt["items"]) ?></span>
            </div>

            <?php if ($opt["user"]->checkPermission("catalog.manage")): ?>
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

<script>
    $(document).ready(function() {
        $('#catalogRatingsContainer').on('click', '.delete-catalogRating', function(event) {
            event.preventDefault();

            Z.Request.action('delete-catalogRating', {
                ratingId: $(this).data('id')
            }, (res) => {
                if (res.result === 'success') {
                    location.reload();
                    return;
                }
            });
        });
    });
</script>

@endsection
