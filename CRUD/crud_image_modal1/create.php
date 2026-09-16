<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Image CRUD</title>
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
                <i class="bi bi-plus-circle text-primary me-2"></i>Add New Product
            </h3>
            <a href="index.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <form action="store.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Product Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                <div class="form-text">Choose an image file (JPG, PNG, GIF, WEBP).</div>
            </div>

            <div id="previewContainer" class="preview-box mb-4" style="display: none;">
                <small class="text-muted d-block mb-2">Image Preview:</small>
                <img id="imagePreview" src="" alt="Preview">
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <a href="index.php" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary-custom px-4">
                    <i class="bi bi-check-lg me-1"></i> Save Product
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