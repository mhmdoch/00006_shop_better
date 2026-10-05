@extends($layout)

@section("content")
    Hello there! You have reached the DashboardController.

    <br><br>

    Check out:
    <a href="<?= $opt["root"] ?>hello/world">
        Hello World
    </a>

    <br><br>

    Data from a model:

@endsection
