<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "<h1>Hello Laravel</h1>";
});

// route single parameter
Route::get('/product/{id}', function ($id) {
    return "Product id : $id";
});

// route multiple parameters
Route::get('/categories/{id}/{name}', function ($id, $name) {
    return "Category id : $id <br>
            Name : $name";
});

// HTTP Request Methods: GET, POST, PUT, PATCH, DELETE

// GET: Retrieve data
Route::get('/get', function () {
    return "GET is used to retrieve data";
});

// POST: Create new data
Route::post('/post', function () {
    return "POST is used to insert or create new data";
});

// PUT: Update an entire resource
Route::put('/put/{id}', function ($id) {
    return "PUT is used to update the entire product: $id";
});

// PATCH: Update specific fields
Route::patch('/patch/{id}', function ($id) {
    return "PATCH is used to update specific fields of product: $id";
});

// DELETE: Delete data
Route::delete('/delete/{id}', function ($id) {
    return "DELETE is used to delete product: $id";
});

// ==============================================================
//                          Route Views
// ==============================================================
// route + view 
Route::get('/home', function(){
    return view('home');
});
// route + view + data
Route::get('/home/{name}', function($name){
    return view('home', compact('name'));
});

// group route

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Admin Dashboard";
    });

    Route::get('/users', function () {
        return "Admin Users";
    });
});