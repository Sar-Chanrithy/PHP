<?php
include "./config/db.php";

if (!isset($_POST['save'])) {
    header("Location: ./index.php");
    exit();
}

$name = trim($_POST['name'] ?? '');
$price = trim($_POST['price'] ?? '');
$imageNew = null;

if ($name === '' || $price === '') {
    header("Location: ./index.php?error=missing_fields");
    exit();
}

$price = floatval($price);

// Handle image upload if provided
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    
    // Allowed image extensions
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extension, $allowed)) {
        $imageNew = uniqid('course_', true) . "." . $extension;
        $uploadDir = "./upload/course/";
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        move_uploaded_file($tmp, $uploadDir . $imageNew);
    }
}

// Insert into `course` table
$stmt = $con->prepare("INSERT INTO course (name, price, image) VALUES (?, ?, ?)");
$stmt->bind_param("sds", $name, $price, $imageNew);

if ($stmt->execute()) {
    header("Location: ./index.php?msg=created");
    exit();
} else {
    header("Location: ./index.php?error=" . urlencode($stmt->error));
    exit();
}
?>
