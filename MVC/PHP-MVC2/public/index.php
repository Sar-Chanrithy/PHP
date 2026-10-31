<?php

$baseDir = preg_replace("#/public$#i", "", str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")));
// $baseDir = http://localhost:8080/Php-Laravel/php-laravel-11-1:30/php-mvc/public/
define("BASE_URL", $baseDir === "/" ? "" : $baseDir);
// BASE_URL = http://localhost:8080/Php-Laravel/php-laravel-11-1:30/php-mvc/
require_once __DIR__ . "/../app/Core/Database.php";


require_once __DIR__ . "/../app/Core/Router.php";

require_once __DIR__ . "/../app/Core/Controller.php";

require_once __DIR__ . "/../app/Models/Model.php";    //new
require_once __DIR__ . "/../app/Models/Product.php";  //new


require_once __DIR__ . "/../app/Controller/HomeController.php";
require_once __DIR__ . "/../app/Controller/ProductController.php";

$router = new Router();

require_once __DIR__ . '/../routes/web.php';

$router->dispatch();
