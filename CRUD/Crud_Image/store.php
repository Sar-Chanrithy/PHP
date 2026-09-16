<?php
include "./config/db.php";

if (isset($_POST['save'])) {
    $name = trim($_POST['name'] ?? '');
    $imageNew = null;

    if (empty($name)) {
        header('Location: ./create.php');
        exit();
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageNew = uniqid() . "." . $extension;
        
        $uploadDir = "./upload/image/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        move_uploaded_file($tmp, $uploadDir . $imageNew);
    }

    $stmt = $con->prepare("INSERT INTO tb_subject (name, image) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $imageNew);
    
    if ($stmt->execute()) {
        header('Location: ./index.php');
        exit();
    } else {
        echo "Database Error: " . $stmt->error;
    }
}
?>