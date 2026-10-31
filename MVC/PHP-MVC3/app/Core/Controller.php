<?php

class Controller 
{
    // Function សម្រាប់ហៅ View មកបង្ហាញ
    public function view(string $view, array $data = []) 
    {
        // ស្រង់ Key ក្នុង array $data ឱ្យក្លាយជា Variable (ឧ. ['name' => 'Dara'] -> $name)
        extract($data);

        $viewPath = __DIR__ . "/../../resources/views/" . $view . ".php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View file [ {$view} ] not found!");
        }
    }
}
