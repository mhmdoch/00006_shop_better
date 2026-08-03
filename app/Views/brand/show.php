<?php return ["body" => function ($opt) { ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/brand/">Marken</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= e($opt["brand"]["name"]) ?></li>
        </ol>
    </nav>

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


        </main>
        <aside class="col-lg-4">
            <div class="bg-box rounded p-4">
                <h5>Übersicht</h5>
                <hr>
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
                    <span><a href="<?= e($opt["brand"]["website"]) ?>" target="_blank" rel="noopener noreferrer">Link</a></span>
                </div>
            </div>
        </aside>
    </div>


<?php }]; ?>