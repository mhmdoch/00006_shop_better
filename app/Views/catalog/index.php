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
                    <h5>Filter</h5><!-- catalog/paginate/all/0/all/name/ASC/10/0 
                    ($catalogsType, $brandId, $name, $orderBy, $sortDir, $pageLimit, $pageOffset)      -->
                </div>
                <hr>
                <div class="row pl-1">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Typ</label>
                            <select class="form-control" name="selectType" id="selectType">
                                <option selected>alle</option>
                                <option value="lego">LEGO</option>
                                <option value="shoe">Schuhe</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Marke</label>
                            <select class="form-control" name="selectBrand" id="selectBrand">
                                <option selected>alle</option>
                                <option value="brand_id">brand_name</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sortieren</label>
                            <select class="form-control" name="selectType" id="selectType">
                                <option selected>alle</option>
                                <option value="value">Typ (aufsteigend)</option>
                                <option value="value">Typ (absteigend)</option>
                                <option value="value">Marke (aufsteigend)</option>
                                <option value="value">Marke (absteigend)</option>
                                <option value="value">Name (aufsteigend)</option>
                                <option value="value">Name (absteigend)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php foreach ($opt["catalogs"] as $catalog) { ?>

        <?php if ($cardsPerRowCurrent % $cardsPerRow === 0) { ?>
            <div class="card-deck">
            <?php } ?>

            <a href="/catalog/show/<?= e($catalog["id"]) ?>" class="card mb-4 rounded">
                <img src="<?php $opt["generateResourceLink"]("assets/img/shoe.png"); ?>" class="card-img-top">
                <div class="card-body">
                    <p class="card-text mb-1"><small><?= e($catalog['brand_name']) ?></small></p>
                    <h5 class="card-title"><?= e($catalog["name"]) ?></h5>
                    <p class="card-text"><?= e($catalog['description']) ?></p>
                    <p class="card-text"><?= e($catalog['lowest_price']) ?></p>
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
<?php }
]; ?>