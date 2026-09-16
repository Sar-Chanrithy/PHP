<?php
    setcookie('user_id', '', time()-60,  '/');
    setcookie('username', '', time()-60,  '/');
    setcookie('email', '', time()-60,  '/');
    setcookie('role', '', time()-60,  '/');


    header('location: Login.php');
    exit;