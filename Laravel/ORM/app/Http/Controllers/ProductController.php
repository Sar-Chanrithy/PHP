<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();

        return view('ORM.read', compact('products'));
    }

    public function store(Request $request)
    {
        $product = [
            "name" => "New Product",
            "price" => 1000,
            "qty" => 10,
            "description" => "new product ...",
        ];

        Product::create($product);

        return "Product created successfully!";
    }

    public function show($id = 4)
    {
        $product = Product::find($id);

        return view("ORM.show", compact("product"));
    }
}