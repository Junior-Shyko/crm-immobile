<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::domain('{tenant}.localhost')->group(function () {
    Route::get('/', function (string $tenant) {
        return $tenant;
    });
});


