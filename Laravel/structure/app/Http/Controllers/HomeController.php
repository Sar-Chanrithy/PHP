<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('PageController.home');
    }

    public function contact(){
        return view('PageController.contact');
    }

    public function product(){
        $products = [
            [
                'id' => 1,
                'title' => 'iPhone 16 Pro',
                'price' => 1099,
                'qty' => 10,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500',
                'description' => 'Apple iPhone with advanced camera and powerful performance.'
            ],
            [
                'id' => 2,
                'title' => 'MacBook Pro M4',
                'price' => 1999,
                'qty' => 5,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500',
                'description' => 'Powerful laptop for programming, design, and professional work.'
            ],
        ];
        return view('PageController.product', compact('products'));
    }
}