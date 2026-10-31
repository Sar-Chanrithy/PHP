<?php

// Route សម្រាប់ទំព័រដើម Home
Router::get('/', ['HomeController', 'index']);

// Route សម្រាប់បង្ហាញបញ្ជី Users
Router::get('/users', ['UserController', 'index']);
