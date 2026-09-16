<?php
require_once "../config/db.php";

// ----------------------------------------------------
// 1. Handle Registration Request
// ----------------------------------------------------
if (isset($_POST['register'])) {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role  = trim($_POST['role'] ?? 'client');
    $pwd   = trim($_POST['pwd'] ?? $_POST['password'] ?? '');

    // Input Validation
    if (empty($name) || empty($email) || empty($pwd)) {
        setcookie('error', 'Please fill in all required fields.', time() + 5, '/');
        header('Location: ../auth/register.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('error', 'Please enter a valid email address.', time() + 5, '/');
        header('Location: ../auth/register.php');
        exit;
    }

    if (strlen($pwd) < 4) {
        setcookie('error', 'Password must be at least 4 characters long.', time() + 5, '/');
        header('Location: ../auth/register.php');
        exit;
    }

    // Role validation (admin or client)
    if (!in_array($role, ['admin', 'client'])) {
        $role = 'client';
    }

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $checkStmt->close();
        setcookie('error', 'An account with this email already exists.', time() + 5, '/');
        header('Location: ../auth/register.php');
        exit;
    }
    $checkStmt->close();

    // Hash password securely
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    // Insert user into database
    $insertStmt = $conn->prepare("INSERT INTO users (username, email, pwd, roles) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
    $success = $insertStmt->execute();
    $insertStmt->close();
    $conn->close();

    if ($success) {
        setcookie('success', 'Registration successful! You can now log in.', time() + 5, '/');
        header('Location: ../auth/login.php');
        exit;
    } else {
        setcookie('error', 'Registration failed. Please try again.', time() + 5, '/');
        header('Location: ../auth/register.php');
        exit;
    }
}

// ----------------------------------------------------
// 2. Handle Login Request
// ----------------------------------------------------
if (isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $pwd   = trim($_POST['pwd'] ?? $_POST['password'] ?? '');

    // Input Validation
    if (empty($email) || empty($pwd)) {
        setcookie('error', 'Please provide both email and password.', time() + 5, '/');
        header('Location: ../auth/login.php');
        exit;
    }

    // Query user by email
    $stmt = $conn->prepare("SELECT id, username, email, pwd, roles FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    // Verify user and password hash
    if ($user && password_verify($pwd, $user['pwd'])) {
        // Set authentication cookies (Valid for 1 day)
        $expireTime = time() + (86400 * 1); // 24 hours
        setcookie('auth_id', $user['id'], $expireTime, '/');
        setcookie('auth_name', $user['username'], $expireTime, '/');
        setcookie('auth_email', $user['email'], $expireTime, '/');
        setcookie('auth_role', $user['roles'], $expireTime, '/');

        // Set success notification cookie
        setcookie('success', "Welcome back, " . htmlspecialchars($user['username']) . "!", time() + 5, '/');

        // Redirect based on role
        if ($user['roles'] === 'admin') {
            header('Location: ../backend/index.php');
        } else {
            header('Location: ../frontend/index.php');
        }
        exit;
    } else {
        setcookie('error', 'Invalid email or password. Please try again.', time() + 5, '/');
        header('Location: ../auth/login.php');
        exit;
    }
}

// Direct access redirect
header('Location: ../auth/login.php');
exit;