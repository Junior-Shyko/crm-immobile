<?php

use Illuminate\Support\Facades\Route;

Route::domain('localhost')->group(function () {
    Route::get('/', function (string $tenant) {
       return "Localhost";
    });
});

Route::domain('{tenant}.localhost')->group(function () {
    Route::get('/', function (string $tenant) {
        Route::view('/', 'welcome');
    });
});


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
