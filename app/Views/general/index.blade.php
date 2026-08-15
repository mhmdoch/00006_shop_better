@extends($layout)

@section("content")
Hi

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
