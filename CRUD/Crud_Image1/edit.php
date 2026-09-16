<?php
require 'config/db.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) die("Product not found");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <h2>Edit Product</h2>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="old_image" value="<?php echo $product['image']; ?>">
        
        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        
        <label>Current Image:</label>
        <img src="upload/product/<?php echo $product['image']; ?>" width="100">
        
        <label>New Image (leave blank to keep current):</label>
        <input type="file" name="image" accept="image/*">
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>