<?php
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $old_image = $_POST['old_image'];
    $new_image = $_FILES['image']['name'];
    
    if (!empty($new_image)) {
        // Upload new image
        $image_new_name = time() . '_' . $new_image;
        $target_file = "upload/product/" . $image_new_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Delete old image
            if (file_exists("upload/product/" . $old_image)) {
                unlink("upload/product/" . $old_image);
            }
            // Update with new image
            $stmt = $pdo->prepare("UPDATE products SET name = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $image_new_name, $id]);
        }
    } else {
        // Update name only
        $stmt = $pdo->prepare("UPDATE products SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }
    
    header("Location: index.php");
    exit;
}
?>