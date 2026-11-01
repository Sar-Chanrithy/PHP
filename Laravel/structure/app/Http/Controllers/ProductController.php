<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public static function index(){
        $products = \App\Models\Product::all();
        return view('mvc-concept.product-list', compact('products'));
    }
}
