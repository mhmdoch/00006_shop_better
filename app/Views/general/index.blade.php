@extends($layout)

@section("content")



<div class="owl-carousel owl-theme">
    <?php foreach ($championCatalogs as $catalog) { ?>
        <?php
            $averageStars = (float) $catalog["average_stars"];
            $roundedStars = round($averageStars * 2) / 2;
            $ratingText = number_format($averageStars, 1, ",", ".");
        ?>
        <a href="<?php echo $opt["root"]; ?>catalog/show/<?= e($catalog["id"]) ?>" class="card mb-4 rounded">
            <?php if ($catalog["titlethumb"]) { ?>
                <img
                    src="<?= $opt["generateResourceLink"](
                        "uploads/thumb_{$catalog['thumb_reference']}.{$catalog['thumb_extension']}"
                    ) ?>"
                    class="card-img-top"
                >
            <?php } else { ?>
                <img src="<?php $opt["generateResourceLink"]("assets/img/{$catalog["itemable_type"]}.png"); ?>" class="card-img-top">
            <?php } ?>
            <div class="card-body py-3 px-2 text-center text-dark" data-test="champion-rating">
                <div class="d-flex justify-content-center text-warning small">
                    <?php for ($star = 1; $star <= 5; $star++): ?>
                        <i class="bi <?= $star <= $roundedStars ? 'bi-star-fill' : ($star - 0.5 <= $roundedStars ? 'bi-star-half' : 'bi-star') ?>"></i>
                    <?php endfor; ?>
                </div>
                <div class="small mt-1"><?= e($ratingText) ?> / 5</div>
            </div>
        </a>
    <?php } ?>
</div>

<div class="breadcrumb mt-4 text-muted">Unser Sortiment</div>

<div class="row no-gutters">
    <a href="<?= e($opt["root"]) ?>catalog/index/shoe/0/all/name/ASC/15/1"
       class="col-6 pr-2" data-test="home-category-shoe">
        <img src="<?php $opt["generateResourceLink"]("assets/img/logo_shoe.png"); ?>"
             class="d-block w-100" style="aspect-ratio: 1 / 1; object-fit: cover;"
             alt="Sneaker entdecken" loading="lazy" decoding="async">
    </a>
    <a href="<?= e($opt["root"]) ?>catalog/index/lego/0/all/name/ASC/15/1"
       class="col-6 pl-2" data-test="home-category-lego">
        <img src="<?php $opt["generateResourceLink"]("assets/img/logo_lego.png"); ?>"
             class="d-block w-100" style="aspect-ratio: 1 / 1; object-fit: cover;"
             alt="LEGO entdecken" loading="lazy" decoding="async">
    </a>
</div>

<div class="breadcrumb mt-4 text-muted">Unsere Newcomer</div>

<div class="owl-carousel owl-theme">
    <?php foreach ($catalogs as $catalog) { ?>
        <a href="<?php echo $opt["root"]; ?>catalog/show/<?= e($catalog["id"]) ?>" class="card mb-4 rounded">
            <?php if ($catalog["titlethumb"]) { ?>
                <img
                    src="<?= $opt["generateResourceLink"](
                        "uploads/thumb_{$catalog['thumb_reference']}.{$catalog['thumb_extension']}"
                    ) ?>"
                    class="card-img-top"
                >
            <?php } else { ?>
                <img src="<?php $opt["generateResourceLink"]("assets/img/{$catalog["itemable_type"]}.png"); ?>" class="card-img-top">
            <?php } ?>
        </a>
    <?php } ?>
</div>

<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel();
    });
</script>

@endsection
