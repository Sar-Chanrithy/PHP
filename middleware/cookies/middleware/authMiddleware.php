<?php

function requireLogin(){
    if(!$_COOKIE['user_id']){
        header("location: ../auth/login.php");
    }
}

function requireAdmin(){
    if($_COOKIE['role'] != 'admin'){
        header("location: ../auth/login.php");
    }
}

function requireClient(){ //admin
    //       true        or        false
    //           true    and       false
    if($_COOKIE['role'] != 'client' and $_COOKIE['role'] != 'admin'){
        header("location: ../auth/login.php");
    }
}