<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    
    if (empty($name)) {
        header("Location: index.php?error=empty_name");
        exit;
    }

    $image = $_FILES['image']['name'] ?? '';
    $tmp_name = $_FILES['image']['tmp_name'] ?? '';
    
    $target_dir = "upload/product/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!empty($image) && is_uploaded_file($tmp_name)) {
        // Create unique image name to prevent overwriting
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $image_new_name = time() . '_' . uniqid() . '.' . strtolower($ext);
        $target_file = $target_dir . $image_new_name;

        if (move_uploaded_file($tmp_name, $target_file)) {
            $stmt = $pdo->prepare("INSERT INTO products (name, image) VALUES (?, ?)");
            $stmt->execute([$name, $image_new_name]);
            header("Location: index.php?msg=added");
            exit;
        } else {
            header("Location: index.php?error=upload_failed");
            exit;
        }
    } else {
        header("Location: index.php?error=no_image");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>