<?php

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home'); 

    }

     public function about()
    {
        return $this->view('about');
    }

     public function contact()
    {
        return $this->view('contact');
    }
}