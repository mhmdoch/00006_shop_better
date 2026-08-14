@extends($layout)

@section("head")
	<link rel="stylesheet" href="<?= $opt["root"]; ?>assets/css/loadCircle.css">
@endsection

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-12 p-0">
                <div class="card bg-darker"> 
                    <div class="panel panel-default">
                        <div class="main-form p-4">
                            <p class="text-center">
                                Eine E-Mail wurde an Sie gesendet. Bitte überprüfen Sie Ihren Posteingang sowie Ihren Spam-Ordner.
                            </p>
                            <a href="<?= $opt["root"]; ?>login">
                                Zurück zum Login
                            </a>
                        </div>
                    </div>
                </div> 
            </div>   
        </div>
    </div>

	<div class="loading" id="loading" style="display: none;">Lädt&#8230;</div>
@endsection
