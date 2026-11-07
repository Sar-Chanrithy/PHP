<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Route::controller(UserController::class)->group(function(){
//     Route::get('/', 'create')->name('create');
//     Route::post('/store', 'store')->name('store');
// });

// Route::controller(ValidationController::class)->group(function(){
//     Route::get('/', 'form')->name('form');
//     Route::post('/validation', 'validation')->name('validation');
// });

Route::controller(UploadController::class)->group(function(){
    Route::get('/', 'form')->name('form');
    Route::post('/upload', 'upload')->name('upload');
});