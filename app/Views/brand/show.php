<?php return ["body" => function ($opt) { ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item"><a href="/brand/">Marken</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= e($opt["brand"]["name"]) ?></li>
        </ol>
    </nav>

    <div class="brand-layout">
        <main class="brand-panel">
            <header class="brand-header">
                <p class="brand-kicker mb-1">Marke</p>
                <h1 class="h2 mb-2"><?= e($opt["brand"]["name"]) ?></h1>
                <p class="text-muted mb-0">Entdecke alle Produkte und verfügbaren Varianten dieser Marke.</p>
            </header>

            <div class="brand-product-grid">
                <?php foreach ($opt["catalogs"] as $catalog) { ?>
                    <article class="brand-product-card">
                        <p class="text-muted small mb-2"><?= e(ucfirst($catalog["itemable_type"])) ?></p>
                        <h2 class="h5 mb-2">
                            <a href="/catalog/show/<?= e($catalog["id"]) ?>">
                                <?= e($catalog["name"]) ?>
                            </a>
                        </h2>
                        <p class="mb-0"><?= e($catalog["description"]) ?></p>
                    </article>
                <?php } ?>

                <?php if (empty($opt["catalogs"])) { ?>
                    <p class="text-muted mb-0">Für diese Marke sind noch keine Produkte vorhanden.</p>
                <?php } ?>
            </div>
        </main>

        <aside class="brand-panel brand-sidebar">
            <h2 class="h5 mb-3">Kurzinfo</h2>

            <dl class="brand-facts mb-0">
                <div>
                    <dt>Produkte</dt>
                    <dd><?= count($opt["catalogs"]) ?></dd>
                </div>
                <div>
                    <dt>Varianten</dt>
                    <dd><?= count($opt["items"]) ?></dd>
                </div>
                <?php if (!empty($opt["brand"]["website"])) { ?>
                    <div>
                        <dt>Website</dt>
                        <dd>
                            <a href="<?= e($opt["brand"]["website"]) ?>" target="_blank" rel="noopener noreferrer">
                                Herstellerseite
                            </a>
                        </dd>
                    </div>
                <?php } ?>
            </dl>
        </aside>
    </div>
<?php }]; ?>