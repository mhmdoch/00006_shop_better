@extends($layout)

@section("content")
    <div class="row">
        <main class="col-lg-12">
            <div class="bg-box rounded p-4 mb-4">
                <h3>
                    Berichtsheft - Übersicht
                    <a href="<?php echo $opt["root"]; ?>reportbook/create" class="bi bi-plus"></a>
                </h3>
            </div>
        </main>
    </div>
@endsection
