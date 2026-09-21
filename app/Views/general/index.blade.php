@extends($layout)

@section("content")
Hi

<?= printf("%.17f", 0.1 + 0.2); ?><br>

<?= $a = 0.1; ?><br>
<?= $b = 0.2; ?><br>

<?= bcadd($a, $b, 17); ?>



@endsection
