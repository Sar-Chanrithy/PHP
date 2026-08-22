<?php

// ឧទាហរណ៍៖ $_SESSION
session_start();
$_SESSION['username'] = 'JohnDoe';
echo "Session Username: " . $_SESSION['username']; // JohnDoe

// ឧទាហរណ៍៖ $_COOKIE
setcookie("user", "JohnDoe", time() + 3600, "/");
echo "Cookie User: " . $_COOKIE['user']; // JohnDoe