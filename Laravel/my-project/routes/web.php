<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    });
