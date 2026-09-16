<?php
include "./config/db.php";

if (!isset($_POST['update'])) {
    header("Location: ./index.php");
    exit();
}

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');
$price = trim($_POST['price'] ?? '');

if (!$id || $name === '' || $price === '') {
    header("Location: ./index.php?error=missing_fields");
    exit();
}

$id = intval($id);
$price = floatval($price);

$uploadDir = "./upload/course/";

// Check if user uploaded a new image
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extension, $allowed)) {
        // Query old image to remove it from disk
        $stmtOld = $con->prepare("SELECT image FROM course WHERE id = ?");
        $stmtOld->bind_param("i", $id);
        $stmtOld->execute();
        $resultOld = $stmtOld->get_result();
        if ($resultOld && $resultOld->num_rows > 0) {
            $oldImage = $resultOld->fetch_assoc()['image'];
            if ($oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
        }

        // Save new image
        $imageNew = uniqid('course_', true) . "." . $extension;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        move_uploaded_file($tmp, $uploadDir . $imageNew);

        // Update database with new image
        $stmt = $con->prepare("UPDATE course SET name = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $name, $price, $imageNew, $id);
    } else {
        // Invalid image format
        header("Location: ./index.php?error=invalid_image");
        exit();
    }
} else {
    // Keep existing image, only update name and price
    $stmt = $con->prepare("UPDATE course SET name = ?, price = ? WHERE id = ?");
    $stmt->bind_param("sdi", $name, $price, $id);
}

if ($stmt->execute()) {
    header("Location: ./index.php?msg=updated");
    exit();
} else {
    header("Location: ./index.php?error=" . urlencode($stmt->error));
    exit();
}
?>
