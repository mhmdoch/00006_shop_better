<?php

use ZubZet\Framework\Routing\Route;

Route::group("", function () {})
    ->middleware([GeneralController::class, "sidebar"]);
