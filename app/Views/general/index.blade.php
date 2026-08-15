@extends($layout)

@section("content")
Hi

<?php foreach (["orange", "apple", "pineapple", "peach"] as $product) { ?>
    <x-test product="{{ $product }}">
        <h2>{{ $product }}</h2>
        Hallo ein Test
    </x-test>
<?php } ?>

<x-newtest>
</x-newtest>

@endsection