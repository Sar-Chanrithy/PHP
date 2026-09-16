<?php
if (file_exists('config/db.php')) {
    require 'config/db.php';
} elseif (file_exists('congfig/db.php')) {
    require 'congfig/db.php';
} else {
    die("Database configuration file not found.");
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: index.php?error=not_found");
    exit;
}

$imagePath = !empty($product['image']) && file_exists('upload/product/' . $product['image'])
    ? 'upload/product/' . $product['image']
    : 'https://placehold.co/120x120?text=No+Image';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Image CRUD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>

<div class="crud-container" style="max-width: 600px;">
    <div class="main-card p-4">
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <h3 class="fw-bold mb-0">
                <i class="bi bi-pencil-square text-primary me-2"></i>Edit Product
            </h3>
            <a href="index.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($product['image']); ?>">
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold d-block">Current Image:</label>
                <div class="preview-box">
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Current Image" style="max-height: 140px;">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">New Image <span class="text-muted fw-normal">(Leave blank to keep current)</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            </div>

            <div id="previewContainer" class="preview-box mb-4" style="display: none;">
                <small class="text-success d-block mb-2 fw-semibold">New Image Preview:</small>
                <img id="imagePreview" src="" alt="New Preview">
            </div>
            
            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <a href="index.php" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-check-lg me-1"></i> Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('imagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            container.style.display = 'none';
        }
    }
</script>
</body>
</html>