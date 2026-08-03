<?php return ["body" => function ($opt) { ?>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">dAShop</a></li>
            <li class="breadcrumb-item active" aria-current="page">Marken</li>
        </ol>
    </nav>

    <a href="/brand/create">Hinzufügen</a> <br>


    <?php foreach ($opt["brands"] as $brand) { ?>
        <a href="/brand/show/<?= e($brand["id"]) ?>"><?= $brand["name"] ?></a> <br>
    <?php } ?>

<?php }]; ?>