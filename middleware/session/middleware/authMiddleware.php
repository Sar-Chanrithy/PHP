<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin(){
    if(!isset($_SESSION['user_id'])){
        header("location: ../auth/login.php");
        exit;
    }
}

function requireAdmin(){
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header("location: ../auth/login.php");
        exit;
    }
}

function requireClient(){ //admin or client
    if(!isset($_SESSION['role']) || ($_SESSION['role'] !== 'client' && $_SESSION['role'] !== 'admin')){
        header("location: ../auth/login.php");
        exit;
    }
}