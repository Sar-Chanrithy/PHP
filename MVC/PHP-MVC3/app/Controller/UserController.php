<?php

require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Models/User.php";

class UserController extends Controller 
{
    public function index() 
    {
        // ១. ហៅ Model មកទាញយក Data
        $users = User::all();

        // ២. បញ្ជូន Data ទៅកាន់ View
        $this->view('users', [
            'title' => 'បញ្ជីឈ្មោះអ្នកប្រើប្រាស់ (User List)',
            'users' => $users
        ]);
    }
}
