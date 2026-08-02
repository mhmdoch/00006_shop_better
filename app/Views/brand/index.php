<?php return ["body" => function ($opt) { ?>

    <a href="/brand/create">Hinzufügen</a> <br>


    <?php foreach ($opt["brands"] as $brand) { ?>
        <a href="/brand/show/<?= e($brand["id"]) ?>"><?= $brand["name"] ?></a> <br>
    <?php } ?>

<?php }]; ?>