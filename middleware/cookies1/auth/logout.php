<?php
// Expire all authentication cookies
$cookiesToClear = ['auth_id', 'auth_name', 'auth_email', 'auth_role'];

foreach ($cookiesToClear as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie($cookie, '', time() - 3600, '/');
        unset($_COOKIE[$cookie]);
    }
}

// Set logout success feedback cookie
setcookie('success', 'You have been safely logged out.', time() + 5, '/');

// Redirect to login page
header('Location: login.php');
exit;
