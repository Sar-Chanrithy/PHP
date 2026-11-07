<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(){
        return view('formSubmit');
    }
    public function store(Request $request){
        // $name = $request->input('name');
        // email = $request->input('email');
        // password = $request->input('password');
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];
        return view('formDisplay', compact('user'));
    }

}
