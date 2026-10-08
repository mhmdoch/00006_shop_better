@extends($layout)

@section("content")



    <div class="row">
        <main class="col-lg-8">
            <div class="bg-box rounded p-4 mb-4">
                <p class="brand-kicker mb-1">Marke</p>
                <h1 class="h2 mb-2"><?= e($opt["brand"]["name"]) ?></h1>
            </div>


<div class="row">
    <main class="col-lg-12">
        <div class="bg-box rounded p-4 mb-4">
            <div class="row pl-3">
                <h5>Filter</h5>
            </div>
            <hr>

            <form id="catalogsFilterForm"></form>

        </div>
    </main>
</div>

<div id="catalogsContainer">
    <x-cataloglistitem :catalogs="$opt['catalogs']" :brand="$opt['brand']" :settings="$opt['settings']" :opt="$opt"/>

    <x-paginationLinks :location="$opt['root'] . 'brand/show/'" :path="$opt['settings']['brandId'] . '/' . $opt['settings']['name'] . '/' . $opt['settings']['price'] . '/' . $opt['settings']['sortKey'] . '/' . $opt['settings']['orderBy'] . '/' . $opt['settings']['limit']" :opt="$opt"/>
    
</div>

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
                <?php endif; ?>

                <div class="d-flex justify-content-between">
                    <span>Produkte</span>
                    <span><?= $opt["settings"]['catalogsAmount'] ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Varianten</span>
                    <span><?= count($opt["items"]) ?></span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Webseite</span>
                    <span>
                        <?php if (filter_var(e($opt["brand"]["website"]), FILTER_VALIDATE_URL) !== false) { ?>

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
                            <span><?= e($log["date"]) ?></span>
                            <span><?= e($log["action"]) ?></span>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </aside>
    </div>

<script>
    var filterForm = Z.Forms.create({
        dom: "catalogsFilterForm",
        hidehints: true
    });

    var filterByName = filterForm.createField({
        name: "filterByName",
        type: "text",
        attributes: { 'data-test': 'filter_by_name' },
        text: "Name",
        width: 4,
        value: <?= json_encode($opt['settings']['name'] === 'all' ? '' : $opt['settings']['name'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
    });
    var filterByPrice = filterForm.createField({
        name: "filterByPrice",
        type: "text",
        attributes: { 'data-test': 'filter_by_price' },
        text: "Maximaler Preis",
        width: 4,
        value: <?= json_encode($opt['settings']['price'] == 999999999 ? '' : (string) $opt['settings']['price']) ?>,
    });
    var sortBy = filterForm.createField({
        name: "sortBy",
        type: "select",
        text: "Sortierung",
        width: 4,
        food: [
            { value: 'name:ASC', text: 'Name aufsteigend' },
            { value: 'name:DESC', text: 'Name absteigend' },
            { value: 'price:ASC', text: 'Preis aufsteigend' },
            { value: 'price:DESC', text: 'Preis absteigend' },
        ],
        value: "<?= e(($opt['settings']['sortKey'] ?: 'name') . ':' . $opt['settings']['orderBy']) ?>",
    });
    filterForm.buttonSubmit.remove();

    function applyFilters() {
        var nameValue = filterByName.value.trim() || 'all';
        var priceValue = filterByPrice.value.trim() || 999999999;
        var sortValues = (sortBy.value || 'name:ASC').split(':');
        var sortByTable = sortValues[0];
        var sortOrderTable = sortValues[1];

        var parameters = [
            nameValue,
            priceValue,
            sortByTable,
            sortOrderTable
        ];

        var url =
            '<?php echo e($opt["root"]); ?>brand/show/<?= e($opt["brand"]["id"]) ?>/' +
            parameters.map(encodeURIComponent).join('/') +
            "/<?= e($opt["settings"]["limit"]) ?>/<?= e($opt["pagination"]["pageCurrent"]) ?>";

        $("#catalogsContainer").load(url + " #catalogsContainer > *");
        window.history.pushState({}, "", url);
    }

    sortBy.on('change', applyFilters);

    $('#catalogsContainer').on('click', '.pagination a', function (event) {
        event.preventDefault();

        var url = this.href;
        $('#catalogsContainer').load(url + ' #catalogsContainer > *');
        window.history.pushState({}, "", url);
    });

    let timer;
    function scheduleFilters() {
        clearTimeout(timer);
        timer = setTimeout(applyFilters, 1000);
    }
    filterByName.on('input', scheduleFilters);
    filterByPrice.on('input', scheduleFilters);
</script>
    
@endsection
