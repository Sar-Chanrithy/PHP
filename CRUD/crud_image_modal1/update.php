<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $old_image = $_POST['old_image'] ?? '';
    $new_image = $_FILES['image']['name'] ?? '';
    $tmp_name = $_FILES['image']['tmp_name'] ?? '';
    $target_dir = "upload/product/";

    if (empty($id) || empty($name)) {
        header("Location: index.php?error=invalid_data");
        exit;
    }

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    if (!empty($new_image) && is_uploaded_file($tmp_name)) {
        // Upload new image with unique name
        $ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $image_new_name = time() . '_' . uniqid() . '.' . strtolower($ext);
        $target_file = $target_dir . $image_new_name;
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Delete old image if file exists
            if (!empty($old_image) && file_exists($target_dir . $old_image)) {
                @unlink($target_dir . $old_image);
            }
            // Update with new image
            $stmt = $pdo->prepare("UPDATE products SET name = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $image_new_name, $id]);
            header("Location: index.php?msg=updated");
            exit;
        } else {
            header("Location: index.php?error=upload_failed");
            exit;
        }
    } else {
        // Update name only
        $stmt = $pdo->prepare("UPDATE products SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        header("Location: index.php?msg=updated");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>