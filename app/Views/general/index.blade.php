@extends($layout)

@section("content")
Hi

<?= printf("%.17f", 0.1 + 0.2); ?><br>

<?= $a = 0.1; ?><br>
<?= $b = 0.2; ?><br>

<?= bcadd($a, $b, 17); ?>

<?php foreach (["orange", "apple", "pineapple", "peach"] as $product) { ?>
    <x-test product="{{ $product }}">
        <h2>{{ $product }}</h2>
        Hallo ein Test
    </x-test>
<?php } ?>

<x-newtest title="bin ich blade?"></x-newtest>

<?php $title2 = "bin ich auch blade?"; ?>
@foreach(str_split($title2) as $letter2)
    <p>{{ $letter2 }}</p>
@endforeach

@endsection
