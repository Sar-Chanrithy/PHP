<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function form(){
        return view('upload.formUpload');
    }

    public function upload(Request $request){
        $request->validate([
            'title' => 'required|string|min:3',
            'image' => 'required|image'
        ]);
        // 'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'

        $imagePath = $request->file('image')->store('uploads', 'public');

        $data = [
            'title' => $request->title,
            'image' => $imagePath
        ];

        return redirect()->route('form')
            ->with('data', $data)
            ->with('success', 'Upload file Successfully.');
    }
}