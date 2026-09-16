<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../config/db.php";

// register
if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $pwd = trim($_POST['pwd']);
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, pwd, roles) VALUES(?, ?, ?, ?)");
    if(!$stmt){
        die("Register query failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
    $register = $stmt->execute();
    if(!$register){
        die("Register failed: " . $stmt->error);
    }
    $stmt->close();
    if($register){
        $_SESSION['success'] = 'Register Successfully';
        header('location: ../auth/login.php');
        exit;
    }
}

// login
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pwd = trim($_POST['pwd']);
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $users = $stmt->get_result();

    if($users->num_rows > 0){
        $user = $users->fetch_assoc();
        if(password_verify($pwd, $user['pwd'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['roles'];

            if($user['roles'] != 'admin'){
                header('location: ../frontend/index.php');
                exit;
            }else{
                header('location: ../backend/index.php');
                exit;
            }
        }else{
            echo "Wrong Password";
        }
    }else{
        echo "Wrong email";
    }
    $stmt->close();
}
$conn->close();