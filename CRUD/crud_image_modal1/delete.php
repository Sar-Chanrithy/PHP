<?php
require 'config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch image name to delete file
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        $image_path = "upload/product/" . $product['image'];
        if (!empty($product['image']) && file_exists($image_path)) {
            @unlink($image_path);
        }
        
        // Delete record from database
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    header("Location: index.php?msg=deleted");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>