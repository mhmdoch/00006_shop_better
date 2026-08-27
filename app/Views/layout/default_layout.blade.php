<!doctype html>
<html class="no-js">

<head>
    <x-zubzet::head :opt="$opt" />
    @yield("head")
    <link href="<?php $opt["generateResourceLink"]("assets/bootstrap-icons/bootstrap-icons.min.css"); ?>" rel="stylesheet">
    <link href="<?php $opt["generateResourceLink"]("assets/css/app.css"); ?>" rel="stylesheet">

</head>

<body id="top" data-test="dashboard-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container navbar-container">

            <a class="navbar-brand" href="#">dAShop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="/catalog/index/all/0/all/name/ASC/15/0">Katalog <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/brand/">Marken</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $opt["root"] ?>cart">Warenkorb</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown link
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div>
                <?php if ($opt["user"]->isLoggedIn) : ?>
                    <span class="text-right">
                        <div class="login-links">

                            <?= e($opt["user"]->fields["email"]) ?>
                            -
                            <a href="<?= $opt["root"] ?>login/logout">Logout</a>
                        </div>
                    </span>
                <?php else : ?>
                    <div id="login-error-label" data-test="error"></div>
                    <div class="login-fields">
                        <input type="email" id="username" data-test="username">
                        <input type="password" id="password" data-test="password">
                        <button id="btnLogin" data-test="btn-login">Login</button>
                    </div>
                    <div class="login-links">
                        <a href="<?= $opt["root"]; ?>login/signup">Registrieren</a>
                        -
                        <a href="<?= $opt["root"]; ?>login/forgot-password">Passwort vergessen?</a>
                    </div>
                    <script>
                        function login() {
                            Z.Presets.Login("username", "password", "login-error-label");
                        }

                        $("#btnLogin").click(() => {
                            login();
                        });

                        $("#username, #password").keyup((e) => {
                            if (e.keyCode == 13) login();
                        });
                    </script>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <div class="container py-5">
        <x-breadcrumb />

        @yield("content")
    </div>

    <x-zubzet::body :opt="$opt" />
</body>

</html>
