<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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


Route::get('/product', function () {
    $products = [
    [
        'id' => 1,
        'title' => 'ASUS ROG Strix G16',
        'price' => 1499,
        'qty' => 10,
        'image' => 'https://cdn.handheld.guru/2026/10/asus-rog-strix-g16-laptop-drops-600-now-under-1400-with-ryzen-9-9955hx-and-rtx-5060-4c601479-1025x720.webp',
        'description' => 'Powerful gaming laptop with Intel Core i7, NVIDIA RTX 4060, 16GB RAM, 1TB SSD, and 16-inch 165Hz display.'
    ],
    [
        'id' => 2,
        'title' => 'ASUS TUF Gaming A15',
        'price' => 999,
        'qty' => 15,
        'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500',
        'description' => 'Affordable gaming laptop with AMD Ryzen 7, NVIDIA RTX 4050, 16GB RAM, 512GB SSD, and 144Hz display.'
    ],
    [
        'id' => 3,
        'title' => 'ASUS ROG Zephyrus G14',
        'price' => 1899,
        'qty' => 8,
        'image' => 'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=500',
        'description' => 'Premium lightweight gaming laptop with AMD Ryzen 9, NVIDIA RTX 4070, 32GB RAM, 1TB SSD, and 14-inch OLED display.'
    ],
    [
        'id' => 4,
        'title' => 'ASUS ROG Strix SCAR 18',
        'price' => 3499,
        'qty' => 5,
        'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500',
        'description' => 'High-performance gaming laptop with Intel Core i9, NVIDIA RTX 4090, 32GB RAM, 2TB SSD, and 18-inch 240Hz display.'
    ],
    [
        'id' => 5,
        'title' => 'ASUS TUF Gaming F15',
        'price' => 1099,
        'qty' => 20,
        'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=500',
        'description' => 'Reliable gaming laptop with Intel Core i7, NVIDIA RTX 4060, 16GB RAM, 512GB SSD, and 15.6-inch 144Hz display.'
    ]
];

    return view('product', compact('products'));
});


// // route name + view
// Route::get('user/', function(){
//     return view('users.index');
// })->name('user.index');

// Route::get('user/create/', function(){
//     return view('users.create');
// })->name('user.create');

// Route::get('user/edit', function(){
//     return view('users.edit');
// })->name('user.edit');

// // group route (prefix , name) + view
// Route::prefix('user')->name('user.')->group(function(){
//     Route::get('/', function(){
//         return view('users.index');
//     })->name('index');

//     Route::get('/create', function(){
//         return view('users.create');
//     })->name('create');

//     Route::get('/edit', function(){
//         return view('users.edit');
//     })->name('edit');
// });

// ===================================
//      Route + Controller
// ===================================
// single route + controller
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/product', [HomeController::class, 'product'])->name('product');

// // group route + controller
// Route::controller(HomeController::class)->group(function(){
//     Route::get('/', 'index')->name('home');
//     Route::get('/contact', 'contact')->name('contact');
//     Route::get('/product', 'product')->name('product');
// });



// route + controller  + model + view 
Route::get('/', [ProductController::class, 'index']);
