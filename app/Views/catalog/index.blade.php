@extends($layout)

@section("content")

<?php
$cardsPerRow = 3;
$cardsPerRowCurrent = 0;
$catalogCount = count($opt["catalogs"]);
?>




<div class="row">
    <main class="col-lg-12">
        <div class="bg-box rounded p-4 mb-4">
            <h3>Katalog - Übersicht</h3>
        </div>
    </main>
</div>

<div class="row">
    <main class="col-lg-12">
        <div class="bg-box rounded p-4 mb-4">
            <div class="row pl-3">
                <h5>Filter</h5>
                <!-- 
                    catalog/index/all/0/all/name/ASC/10/0 
                    ($catalogsType, $brandId, $name, $orderBy, $sortDir, $pageLimit, $pageOffset)
                    -->
            </div>
            <hr>
            <div class="row pl-1">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Typ</label>
                        <select class="form-control" name="selectType" id="selectType">
                            <option selected value="all">alle</option>
                            <option value="lego">LEGO</option>
                            <option value="shoe">Schuhe</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Marke</label>
                        <select class="form-control" name="selectBrand" id="selectBrand">
                            <option selected value="0">alle</option>
                            <?php foreach ($opt["brands"] as $brand) { ?>
                                <option value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="selectName" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sortieren</label>
                        <select class="form-control" name="selectSort" id="selectSort">
                            <!-- <option selected value="all" data-direction="ASC">alle</option> -->
                            <option value="type" data-direction="ASC">Typ (aufsteigend)</option>
                            <option value="type" data-direction="DESC">Typ (absteigend)</option>
                            <option value="brand" data-direction="ASC">Marke (aufsteigend)</option>
                            <option value="brand" data-direction="DESC">Marke (absteigend)</option>
                            <option selected value="name" data-direction="ASC">Name aufsteigend</option>
                            <option value="name" data-direction="DESC">Name absteigend</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<form id="catalogsFilterForm"></form>


<div id="catalogsContainer">
    <?php foreach ($opt["catalogs"] as $catalog) { ?>

        <?php if ($cardsPerRowCurrent % $cardsPerRow === 0) { ?>
            <div class="card-deck">
            <?php } ?>

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

<nav aria-label="Page navigation example">
    <ul class="pagination  justify-content-center">
        <li class="page-item">
            <a class="page-link" href='/catalog/index/<?= $opt["settings"]["type"] ?>/<?= $opt["settings"]["brandId"] ?>/<?= $opt["settings"]["name"] ?>/<?= $opt["settings"]["sortKey"] ?>/<?= $opt["settings"]["orderBy"] ?>/<?= $opt["settings"]["limit"] ?>/1' aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php for ($i = $opt["pagination"]["pageCurrent"] - $opt["pagination"]["pageNeighboorsLeft"]; $i < $opt["pagination"]["pageCurrent"]; $i++): ?>
            <li class="page-item"><a class="page-link" href='/catalog/index/<?= $opt["settings"]["type"] ?>/<?= $opt["settings"]["brandId"] ?>/<?= $opt["settings"]["name"] ?>/<?= $opt["settings"]["sortKey"] ?>/<?= $opt["settings"]["orderBy"] ?>/<?= $opt["settings"]["limit"] ?>/<?= $i ?>'><?= $i ?></a></li>
        <?php endfor; ?>

        <li class="page-item active"><span class="page-link" deactivated href='/catalog/index/<?= $opt["settings"]["type"] ?>/<?= $opt["settings"]["brandId"] ?>/<?= $opt["settings"]["name"] ?>/<?= $opt["settings"]["sortKey"] ?>/<?= $opt["settings"]["orderBy"] ?>/<?= $opt["settings"]["limit"] ?>/<?= $opt["pagination"]["pageCurrent"] ?>'><strong><?= $opt["pagination"]["pageCurrent"] ?></strong></span></li>

        <?php for ($i = $opt["pagination"]["pageCurrent"] + 1; $i <= $opt["pagination"]["pageCurrent"] + $opt["pagination"]["pageNeighboorsRight"]; $i++): ?>
            <li class="page-item"><a class="page-link" href="/catalog/index/<?= $opt["settings"]["type"] ?>/<?= $opt["settings"]["brandId"] ?>/<?= $opt["settings"]["name"] ?>/<?= $opt["settings"]["sortKey"] ?>/<?= $opt["settings"]["orderBy"] ?>/<?= $opt["settings"]["limit"] ?>/<?= $i ?>"><?= $i ?></a></li>
        <?php endfor; ?>

        <li class="page-item">
            <a class="page-link" href='/catalog/index/<?= $opt["settings"]["type"] ?>/<?= $opt["settings"]["brandId"] ?>/<?= $opt["settings"]["name"] ?>/<?= $opt["settings"]["sortKey"] ?>/<?= $opt["settings"]["orderBy"] ?>/<?= $opt["settings"]["limit"] ?>/<?= $opt["pagination"]["pageLast"] ?>' aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

</div>

<script>
    var filterForm = Z.Forms.create({
        dom: "catalogsFilterForm"
    });

    var filterByType = filterForm.createField({
        name: "filterByType",
        type: "hidden",
        value: "<?= $opt['settings']['type'] ?>" ?? 'all',
    });
    var filterByBrand = filterForm.createField({
        name: "filterByBrand",
        type: "hidden",
        value: "<?= $opt['settings']['brandId'] ?>" ?? '0',
    });
    var filterByName = filterForm.createField({
        name: "filterByName",
        type: "hidden",
        value: "<?= $opt['settings']['name'] ?>" ?? 'all',
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
        var typeValue = $('#selectType').val();
        var brandValue = $('#selectBrand').val();
        var nameValue = $('#selectName').val().trim();
        var sortByTable = $('#selectSort').val();
        var sortOrderTable = $('#selectSort option:selected').data('direction');

        if (nameValue === '') {
            nameValue = 'all';
        }

        var parameters = [
            typeValue,
            brandValue,
            nameValue,
            sortByTable,
            sortOrderTable
        ];

        var url =
            '/catalog/index/' +
            parameters.map(encodeURIComponent).join('/') +
            "/<?= $opt["settings"]["limit"] ?>/<?= $opt["pagination"]["pageCurrent"] ?>";
        // How it works
        // ----------------------
        // var parameters = ['shoe', '12', 'Air Max'];
        // var encodedParameters = parameters.map(function(parameter) {
        //     return encodeURIComponent(parameter);
        // });
        // var path = encodedParameters.join('/');
        // console.log(path);
        // "shoe/12/Air%20Max"

        $("#catalogsContainer").load(url + " #catalogsContainer > *");
        window.history.pushState({}, "", url);
    }

    $('#selectType, #selectBrand, #selectSort').on('change', applyFilters);

    let timer;
    $('#selectName').on('input', function () {
        clearTimeout(timer);
        timer = setTimeout(applyFilters, 1000);
    });
</script>
@endsection