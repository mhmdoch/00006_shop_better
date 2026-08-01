<?php return ["body" => function ($opt) { ?>
    Hello there! You have reached the DashboardController.


    Data from a model:
    <ul>
        <?php foreach ($opt["catalogs"] as $catalog) { ?>
            <li>
                <a href="/catalog/show/<?= e($catalog['id']) ?>"><?= e($catalog["name"]) ?></a>
            </li>
        <?php } ?>
    </ul>
<?php }]; ?>