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
            <h3>Katalog - Übersicht <a href="<?php echo $opt["root"]; ?>catalog/create" class="bi bi-plus" data-id="" title="erstellen"></a></h3>
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

            <form id="catalogsFilterForm"></form>

            <!-- <div class="row pl-1">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Typ</label>
                        <select class="form-control" name="selectType" id="selectType" data-test="filter_by_type">
                            <option selected value="all">alle</option>
                            <option value="lego">LEGO</option>
                            <option value="shoe">Schuhe</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Marke</label>
                        <select class="form-control" name="selectBrand" id="selectBrand" data-test="filter_by_brand">
                            <option selected value="0">alle</option>
                            <?php foreach ($opt["brands"] as $brand) { ?>
                                <option value="<?= e($brand['id']) ?>"><?= e($brand['name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control" id="selectName" aria-describedby="emailHelp" data-test="filter_by_name">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sortieren</label>
                        <select class="form-control" name="selectSort" id="selectSort">
                          
                            <option value="type" data-direction="ASC">Typ (aufsteigend)</option>
                            <option value="type" data-direction="DESC">Typ (absteigend)</option>
                            <option value="brand" data-direction="ASC">Marke (aufsteigend)</option>
                            <option value="brand" data-direction="DESC">Marke (absteigend)</option>
                            <option selected value="name" data-direction="ASC">Name aufsteigend</option>
                            <option value="name" data-direction="DESC">Name absteigend</option>
                        </select>
                    </div>
                </div>
            </div> -->
        </div>
    </main>
</div>

<div id="catalogsContainer">

<x-cataloglistitem :catalogs="$opt['catalogs']" :brands="$opt['brands']" :settings="$opt['settings']" :pagination="$opt['pagination']" :opt="$opt"/>

<x-paginationLinks :location="$opt['root'] . 'catalog/index/'" :path="$opt['settings']['type'] . '/' . $opt['settings']['brandId'] . '/' . $opt['settings']['name'] . '/' . $opt['settings']['sortKey'] . '/' . $opt['settings']['orderBy'] . '/' . $opt['settings']['limit']" :opt="$opt"/>


</div>

<script>
    var filterForm = Z.Forms.create({
        dom: "catalogsFilterForm",
        hidehints: true
    });

    var filterByType = filterForm.createField({
        name: "filterByType",
        type: "select",
        attributes: { 'data-test': 'filter_by_type' },
        text: "Typ",
        width: 3,
        food: <?= json_encode($opt['typeOptions']) ?>,
        value: "<?= e($opt['settings']['type']) ?>" ?? 'all',
    });
    var filterByBrand = filterForm.createField({
        name: "filterByBrand",
        type: "select",
        attributes: { 'data-test': 'filter_by_brand' },
        text: "Marke",
        width: 3,
        food: <?= $opt['brandOptions'] ?>,
        value: "<?= e($opt['settings']['brandId']) ?>" ?? '0',
    });
    var filterByName = filterForm.createField({
        name: "filterByName",
        type: "text",
        attributes: { 'data-test': 'filter_by_name' },
        text: "Name",
        width: 3,
        value: "<?= ($opt['settings']['name'] === 'all' ? '' : $opt['settings']['name']) ?>",
    });
    var sortBy = filterForm.createField({
        name: "sortBy",
        type: "select",
        text: "Sortierung",
        width: 3,
        food: [
            { value: 'name:ASC', text: 'Name aufsteigend' },
            { value: 'name:DESC', text: 'Name absteigend' },
            { value: 'type:ASC', text: 'Typ aufsteigend' },
            { value: 'type:DESC', text: 'Typ absteigend' },
            { value: 'brand:ASC', text: 'Marke aufsteigend' },
            { value: 'brand:DESC', text: 'Marke absteigend' },
        ],
        value: "<?= e(($opt['settings']['sortKey'] ?: 'name') . ':' . $opt['settings']['orderBy']) ?>",
    });
    filterForm.buttonSubmit.remove();

    function applyFilters() {
        var typeValue = filterByType.value || 'all';
        var brandValue = filterByBrand.value || '0';
        var nameValue = filterByName.value.trim();
        var sortValues = (sortBy.value || 'name:ASC').split(':');
        var sortByTable = sortValues[0];
        var sortOrderTable = sortValues[1];

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
            '<?php echo $opt["root"]; ?>catalog/index/' +
            parameters.map(encodeURIComponent).join('/') +
            "/<?= e($opt["settings"]["limit"]) ?>/<?= e($opt["pagination"]["pageCurrent"]) ?>";

        $("#catalogsContainer").load(url + " #catalogsContainer > *");
        window.history.pushState({}, "", url);
    }

    filterByType.on('change', applyFilters);
    filterByBrand.on('change', applyFilters);
    sortBy.on('change', applyFilters);

    $('#catalogsContainer').on('click', '.pagination a', function (event) {
        event.preventDefault();

        var url = this.href;
        $('#catalogsContainer').load(url + ' #catalogsContainer > *');
        window.history.pushState({}, "", url);
    });

    let timer;
    filterByName.on('input', function () {
        clearTimeout(timer);
        timer = setTimeout(applyFilters, 1000);
    });
</script>
@endsection
