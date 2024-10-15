<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return true;
});

require __DIR__ . '/auth.php';
