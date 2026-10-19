<?php

use ZubZet\Framework\Routing\Route;

Route::group("", function () {})
    ->middleware([GeneralController::class, "sameOriginOnly"])
    ->middleware([GeneralController::class, "sidebar"])
    ->middleware([GeneralController::class, "shoppingCardCookie"]);