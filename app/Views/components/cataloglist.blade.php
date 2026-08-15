@props([
    "catalog",
    "opt",
])




            <a href="/catalog/show/<?= e($catalog["id"]) ?>" class="card mb-4 rounded">
                <img src="<?php $opt["generateResourceLink"]("assets/img/{$catalog["itemable_type"]}.png"); ?>" class="card-img-top">
                <div class="card-body">
                    <p class="card-text mb-1"><small><?= e($catalog['brand_name']) ?></small></p>
                    <h5 class="card-title"><?= e($catalog["name"]) ?></h5>
                    <p class="card-text"><?= e($catalog['description']) ?></p>
                    <p class="card-text">
                        <?php if ($catalog["lowest_price"] !== null) { ?>
                            ab <?= e(number_format((float) $catalog["lowest_price"], 2, ",", ".")) ?> €
                        <?php } else { ?>
                            Noch kein Preis
                        <?php } ?>
                    </p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </a>