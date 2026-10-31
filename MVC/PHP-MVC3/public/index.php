<?php

// ១. ហៅ Core Files
require_once __DIR__ . "/../app/Core/Database.php";
require_once __DIR__ . "/../app/Core/Router.php";

// ២. ហៅ Routes
require_once __DIR__ . "/../routes/web.php";

// ៣. ចាប់ផ្តើម Dispatch Route
Router::dispatch();
