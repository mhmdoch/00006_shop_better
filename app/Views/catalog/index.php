<?php return [
    "body" => function ($opt) { ?>

    <?php
        $cardsPerRow = 3;
        $cardsPerRowCurrent = 0;
        $catalogCount = count($opt["catalogs"]);
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Katalog</li>
        </ol>
    </nav>
    <?php foreach ($opt["catalogs"] as $catalog) { ?>

        <?php if ($cardsPerRowCurrent % $cardsPerRow === 0) { ?>
            <div class="card-deck">
            <?php } ?>

            <div class="card mb-4 rounded">
                <img src="..." class="card-img-top" alt="<?= e($catalog["name"]) ?>">
                <div class="card-body">
                    <p class="card-text mb-1"><small><?= e($catalog['brand_name']) ?></small></p>
                    <h5 class="card-title"><?= e($catalog["name"]) ?></h5>
                    <p class="card-text"><a href="/catalog/show/<?= e($catalog["id"]) ?>"><?= e($catalog['description']) ?></a></p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
            <?php $cardsPerRowCurrent++; ?>

            <?php if ($cardsPerRowCurrent % $cardsPerRow === 0) { ?>
            </div>
        <?php } ?>
    <?php } ?>


    <?php if ($cardsPerRowCurrent % $cardsPerRow !== 0) { ?>
        <?php $cardsPerRowMissing = $cardsPerRow - ($cardsPerRowCurrent % $cardsPerRow); ?>

        <?php for ($i = 0; $i < $cardsPerRowMissing; $i++) { ?>
            <div class="card mb-4 invisible" aria-hidden="true"></div>
        <?php } ?>

        </div>
    <?php } ?>
<?php }
]; ?>