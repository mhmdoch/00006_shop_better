@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <h1 class="h2 mb-2"><?= e($opt["discount"]["code"]) ?></h1>
            </div>

            <div class="bg-box rounded p-4">
                <div class="d-flex justify-content-between">
                    <span>Rabatt</span>
                    <span>
                        <?= e(number_format((float) $opt["discount"]["value"], 2, ",", ".")) ?>
                        <?= $opt["discount"]["type"] === "percent" ? "%" : "€" ?>
                    </span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>Mindestbestellwert</span>
                    <span><?= e(\App\Helper\AppHelper::price($opt["discount"]["min_total"])) ?></span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>Status</span>
                    <span><?= $opt["discount"]["active"] ? "aktiv" : "inaktiv" ?></span>
                </div>
            </div>
        </main>

        <aside class="col-lg-4">
            <div class="bg-box rounded p-4">
                <h5>Verwaltung</h5>
                <hr>
                <div> - <a href="<?= e($opt["root"]) ?>discount/">Index</a></div>
                <div class="mt-2"> - <a href="<?= e($opt["root"]) ?>discount/edit/<?= e($opt["discount"]["id"]) ?>">Status ändern</a></div>
            </div>
        </aside>
    </div>
@endsection
