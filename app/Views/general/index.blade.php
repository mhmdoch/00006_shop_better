@extends($layout)

@section("content")



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

<?= printf("%.17f", 0.1 + 0.2); ?><br>

<?= $a = 0.1; ?><br>
<?= $b = 0.2; ?><br>

<?= bcadd($a, $b, 17); ?>

<?php var_dump($opt["root"]); ?>

<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel();
    });
</script>

@endsection
