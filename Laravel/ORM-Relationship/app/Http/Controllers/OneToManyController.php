<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class OneToManyController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')
            ->orderBy('id', 'desc')
            ->get();

        return view('OneToMany.index', compact('categories'));
    }
}