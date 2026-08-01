<?php return ["body" => function ($opt) { ?>
    Hello there! You have reached the DashboardController.


    Data from a model:
    <ul>
        <li>
            <?= $opt["catalog"]["name"] ?> </li>

        <?php foreach ($opt["items"] as $item) { ?>
            <li>
                <?= e($item["color"]) ?>
            </li>
        <?php } ?>
    </ul>
<?php }]; ?>