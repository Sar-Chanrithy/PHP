<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    
    // Create unique image name to prevent overwriting
    $image_new_name = time() . '_' . $image;
    $target_dir = "upload/product/";
    $target_file = $target_dir . $image_new_name;

    if (move_uploaded_file($tmp_name, $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, image) VALUES (?, ?)");
        $stmt->execute([$name, $image_new_name]);
        header("Location: index.php");
        exit;
    } else {
        echo "Failed to upload image.";
    }
}
?>