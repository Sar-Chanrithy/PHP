<?php

require_once __DIR__ . "/../Core/Controller.php";

class HomeController extends Controller 
{
    public function index() 
    {
        // បញ្ជូន Data ទៅកាន់ View
        $data = [
            'title' => 'ទំព័រដើម (Home Page)',
            'message' => 'សូមស្វាគមន៍មកកាន់ PHP MVC Tutorial!'
        ];

        // ហៅ View home.php ក្នុង resources/views/
        $this->view('home', $data);
    }
}
