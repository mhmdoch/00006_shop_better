  @props(["opt"])

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container navbar-container">

            <a class="navbar-brand" href="<?php echo $opt["root"]; ?>">dAShop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= ($opt["navMenu"] ?? "") == "catalog" ? "active" : "" ?>"
                            href="<?php echo $opt["root"]; ?>catalog/index/all/0/all/name/ASC/15/1"
                            data-test="nav-catalog">Katalog <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($opt["navMenu"] ?? "") == "brand" ? "active" : "" ?>" href="<?php echo $opt["root"]; ?>brand/">Marken</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($opt["navMenu"] ?? "") == "cart" ? "active" : "" ?>" href="<?php echo $opt["root"]; ?>cart">Warenkorb</a>
                    </li>
                    <?php if ($opt["user"]->checkPermission("order.own")): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($opt["navMenu"] ?? "") == "order" ? "active" : "" ?>" href="<?php echo $opt["root"]; ?>order/own">Meine Bestellungen</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($opt["user"]->checkPermission("order.index")): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($opt["navMenu"] ?? "") == "allorder" ? "active" : "" ?>" href="<?= $opt["root"] ?>order" data-test="nav-all-order">Alle Bestellungen</a>
                        </li>
                    <?php endif; ?>
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
                    <div id="login-error-label-Nav" data-test="errorNav"></div>
                    <div class="login-fields">
                        <input type="email" id="usernameNav" data-test="usernameNav">
                        <input type="password" id="passwordNav" data-test="passwordNav">
                        <button id="btnLoginNav" data-test="btn-loginNav">Login</button>
                    </div>
                    <div class="login-links">
                        <a href="<?= $opt["root"]; ?>login/signup">Registrieren</a>
                        -
                        <a href="<?= $opt["root"]; ?>login/forgot-password">Passwort vergessen?</a>
                    </div>
                    <script>
                        function loginNav() {
                            Z.Presets.Login("usernameNav", "passwordNav", "login-error-label-Nav");
                        }

                        $("#btnLoginNav").click(() => {
                            loginNav();
                        });

                        $("#usernameNav, #passwordNav").keyup((e) => {
                            if (e.keyCode == 13) loginNav();
                        });
                    </script>
                <?php endif; ?>
            </div>

        </div>
    </nav>