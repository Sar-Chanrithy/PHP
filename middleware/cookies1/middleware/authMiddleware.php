<?php
/**
 * Authentication and Authorization Middleware using Cookies
 */

/**
 * Retrieve the currently authenticated user from cookies.
 *
 * @return array|null Returns user data array or null if unauthenticated.
 */
function getAuthUser() {
    if (isset($_COOKIE['auth_id']) && isset($_COOKIE['auth_role'])) {
        return [
            'id'       => $_COOKIE['auth_id'],
            'username' => $_COOKIE['auth_name'] ?? 'User',
            'email'    => $_COOKIE['auth_email'] ?? '',
            'role'     => $_COOKIE['auth_role']
        ];
    }
    return null;
}

/**
 * Middleware: Ensure the user is logged in.
 *
 * @param string $loginPath Redirect destination if not authenticated.
 * @return array Returns authenticated user data.
 */
function checkAuth($loginPath = '../auth/login.php') {
    $user = getAuthUser();
    if (!$user) {
        setcookie('error', 'Please log in to access this page.', time() + 5, '/');
        header("Location: $loginPath");
        exit;
    }
    return $user;
}

/**
 * Middleware: Ensure the user is logged in AND has the 'admin' role.
 *
 * @param string $clientDashboard Redirect destination if user is a client.
 * @param string $loginPath Redirect destination if user is not logged in.
 * @return array Returns authenticated admin user data.
 */
function checkAdmin($clientDashboard = '../frontend/index.php', $loginPath = '../auth/login.php') {
    $user = checkAuth($loginPath);
    if ($user['role'] !== 'admin') {
        setcookie('error', 'Access denied: Admin privileges required.', time() + 5, '/');
        header("Location: $clientDashboard");
        exit;
    }
    return $user;
}

/**
 * Middleware: Ensure user is a guest (not logged in).
 * If user is already logged in, redirect them to their respective dashboard.
 *
 * @param string $adminPath Redirect destination for admin.
 * @param string $clientPath Redirect destination for client.
 */
function checkGuest($adminPath = '../backend/index.php', $clientPath = '../frontend/index.php') {
    $user = getAuthUser();
    if ($user) {
        if ($user['role'] === 'admin') {
            header("Location: $adminPath");
            exit;
        } else {
            header("Location: $clientPath");
            exit;
        }
    }
}
