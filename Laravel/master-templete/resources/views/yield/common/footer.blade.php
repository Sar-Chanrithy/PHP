<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return redirect()->route('home');
});

Route::get('/home', function(){
    return view('yield.pages.home');
})->name('home');

Route::get('/about', function(){
    return view('yield.pages.about');
})->name('about');