<?php

use Illuminate\Support\Facades\Route;


Route::domain('localhost')->group(function () {
    Route::get('/', function (string $account, string $id) {
       return view('welcome');
    });
});

Route::domain('{account}.localhost')->group(function () {
    Route::get('/', function (string $account) {
        return view('welcome');
    });
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
