@extends($layout)

@section("content")

<?php
$cardsPerRow = 3;
$cardsPerRowCurrent = 0;
$catalogCount = count($opt["catalogs"]);
?>

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
                <!-- 
                    catalog/paginate/all/0/all/name/ASC/10/0 
                    ($catalogsType, $brandId, $name, $orderBy, $sortDir, $pageLimit, $pageOffset)
                    -->
            </div>
            <hr>
            <div class="row pl-1">
                                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="selectName" aria-describedby="emailHelp">
                    </div>
                </div>
                                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Maximaler Preis</label>
                        <input type="text" class="form-control" id="selectName" aria-describedby="emailHelp">
                    </div>
                </div>


                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sortieren</label>
                        <select class="form-control" name="selectSort" id="selectSort">
                            <!-- <option selected value="all" data-direction="ASC">alle</option> -->
                            <option value="type" data-direction="ASC">Preis (aufsteigend)</option>
                            <option value="type" data-direction="DESC">Preis (absteigend)</option>
                            <option selected value="name" data-direction="ASC">Name aufsteigend</option>
                            <option value="name" data-direction="DESC">Name absteigend</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

    <x-cataloglist2 :catalogs="$opt['catalogs']" :opt="$opt"></x-cataloglist>


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
                <? endif; ?>

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
                    <span>
                        <?php if (filter_var($opt["brand"]["website"], FILTER_VALIDATE_URL) !== false) { ?>

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
                            <span><?= $log["date"] ?></span>
                            <span><?= $log["action"] ?></span>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </aside>
    </div>

<script>
    var filterForm = Z.Forms.create({
        dom: "catalogsFilterForm"
    });

    var filterByName = filterForm.createField({
        name: "filterByName",
        type: "hidden",
        value: "<?= $opt['settings']['name'] ?>" ?? 'all',
    });
    var filterByPrice = filterForm.createField({
        name: "filterByPrice",
        type: "hidden",
        value: "<?= $opt['settings']['price'] ?>" ?? 'all',
    });
    var sortBy = filterForm.createField({
        name: "sortBy",
        type: "hidden",
    });
    var sortOrder = filterForm.createField({
        name: "sortOrder",
        type: "hidden",
    });
    filterForm.buttonSubmit.remove();

    function applyFilters() {
        var nameValue = $('#selectName').val();
        var priceValue = $('#filterByPrice').val();
        var sortByTable = $('#selectSort').val();
        var sortOrderTable = $('#selectSort option:selected').data('direction');

        if (nameValue === '') {
            nameValue = 'all';
        }

        var parameters = [
            nameValue,
            priceValue,
            sortByTable,
            sortOrderTable
        ];

        var url =
            '/brand/show/<?= $opt["brand"]["id"] ?>' +
            parameters.map(encodeURIComponent).join('/') +
            "/<?= $opt["settings"]["limit"] ?>/<?= $opt["settings"]["pageCurrent"] ?>";

        $("#catalogsContainer").load(url + " #catalogsContainer > *");
        window.history.pushState({}, "", url);
    }

    $('#selectType, #selectBrand, #selectSort').on('change', applyFilters);
    $('#selectName').on('input', applyFilters);
</script>
    
@endsection
