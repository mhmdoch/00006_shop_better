@extends($layout)

@section("head")

@endsection

@section("content")
    <div class="mb-3">
        <a href="<?= $opt["url"]; ?>" class="text-primary font-weight-bold">Hier klicken</a>,
        um deine E-Mail-Adresse zu verifizieren.
    </div>

    <div class="mb-3">
        Oder diesen Link kopieren:<br>
        <a href="<?= $opt["url"]; ?>">
            <?= $opt["url"]; ?>
        </a>
    </div>
@endsection
