<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneToOneController;

Route::get('/', [OneToOneController::class, 'index']);
Route::get('destroy', [OneToOneController::class, 'destroy']);