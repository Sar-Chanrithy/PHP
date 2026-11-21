<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('read');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/read', 'index')->name('read');
    Route::get('/store', 'store');
    Route::get('/show/{id?}', 'show');
    Route::get('/update/{id?}', 'update');
    Route::get('/destroy/{id?}', 'destroy');
});