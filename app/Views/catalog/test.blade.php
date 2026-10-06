@extends($layout)

@section("content")

<img src="<?= $opt['root'] ?>uploads/<?= $opt["titlethumb"]["reference"] ?>.jpg" />
<img src="<?= $opt['root'] ?>uploads/thumb_<?= $opt["titlethumb"]["reference"] ?>.jpg" />

<?= $opt["titlethumb"]["reference"] ?><br>
<?= $opt["titlethumb"]["extension"] ?>


@endsection

