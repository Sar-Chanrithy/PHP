<?php
// Root router: Check cookie and redirect to appropriate location
if (isset($_COOKIE['auth_id']) && isset($_COOKIE['auth_role'])) {
    if ($_COOKIE['auth_role'] === 'admin') {
        header('Location: backend/index.php');
        exit;
    } else {
        header('Location: frontend/index.php');
        exit;
    }
}

// Otherwise send to login page
header('Location: auth/login.php');
exit;