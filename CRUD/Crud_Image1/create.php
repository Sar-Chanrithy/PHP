<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <h2>Add New Product</h2>
    <form action="store.php" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" required>
        
        <label>Product Image:</label>
        <input type="file" name="image" accept="image/*" required>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="index.php">Cancel</a>
    </form>
</body>
</html>