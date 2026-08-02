<?php return ["body" => function ($opt) { ?>



    <div class="row">
        <div class="col-9">asd</div>
        <div class="col-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kurzinfo:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Produkte:</td>
                        <td><?= count($opt["catalogs"]) ?></td>
                    </tr>
                    <tr>
                        <td>Varianten:</td>
                        <td><?= count($opt["catalogs"]) ?></td>
                    </tr>
                    <tr>
                        <td>July</td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    Brand:
    <ul>
        <li>
            <?= $opt["brand"]["name"] ?> </li>


    </ul>


    <?php foreach ($opt["catalogs"] as $catalog) { ?>
        <li>
            <?= e($catalog["name"]) ?>
        </li>
    <?php } ?>
<?php }]; ?>