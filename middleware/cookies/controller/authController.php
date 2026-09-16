<?php
require_once __DIR__ . "/../config/db.php";

// register
if(isset($_POST['register'])){
    $email = trim($_POST['email'] ?? '');
    $pwd = trim($_POST['pwd'] ?? '');
    if($email === '' || $pwd === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("A valid email and password are required.");
    }
    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, pwd) VALUES(?, ?, ?)");
    if(!$stmt){
        die("Register query failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $email, $email, $hashedPassword);
    $register = $stmt->execute();
    if(!$register){
        die("Register failed: " . $stmt->error);
    }
    $stmt->close();
    if($register){
        setcookie('success', 'Register Successfully', time() + 10, '/');
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
            setcookie('user_id', $user['id'], time()+60, '/');
            setcookie('username', $user['username'], time()+60, '/');
            setcookie('email', $user['email'], time()+60, '/');
            setcookie('role', $user['roles'], time()+60, '/');

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