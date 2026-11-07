<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function form() {
        return view('validation.formValidation');
    }

    public function validation(Request $request) {
        $validation = $request->validate([
            'title' => 'required|string|min:3|max:7',
            'price' => 'required|numeric|min:1',
            'qty' => 'required|numeric|min:1',
            'description' => 'nullable'
        ]);

        $title = $request->input('title');
        $price = $request->input('price');
        $qty = $request->input('qty');
        $description = $request->input('description');

        $product = [
            'title' => $title,
            'price' => $price,
            'qty' => $qty,
            'description' => $description
        ];

        return redirect()->route('form')
            ->with('product', $product)
            ->with('success', 'Form Submitted Successfully.');
    }
}