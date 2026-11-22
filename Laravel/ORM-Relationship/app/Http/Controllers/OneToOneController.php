<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class OneToOneController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->orderBy('id', 'desc')->get();
        return view('OneToOne.index', compact('users'));
    }
    public function destroy()
    {
        // $profile = Profile::find(1);
        // $profile->delete();
        $user = User::find(2);
        $user->delete();
        return "profile Delete Successfully";
        
    }
}
