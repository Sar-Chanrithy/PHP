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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = 4)
    {
        $product = Product::findOrFail($id);

        $data = [
            "name" => "Update Product",
            "price" => 2000,
            "qty" => 20,
            "description" => "update product ....",
        ];

        $product->update($data);

        return "Product Updated Successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = 4)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return "Product Deleted Successfully";
    }
}