<?php
include 'config/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php?error=Invalid item ID");
    exit();
}

// Fetch existing product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php?error=Product not found");
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        header("Location: edit.php?id=$id&error=Name is required");
        exit();
    }

    // Check if new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filesize = $_FILES['image']['size'];

        if (!in_array($filetype, $allowed)) {
            header("Location: edit.php?id=$id&error=Only JPG, JPEG, PNG, GIF, and WEBP files are allowed");
            exit();
        }

        if ($filesize > 5 * 1024 * 1024) {
            header("Location: edit.php?id=$id&error=File size must be less than 5MB");
            exit();
        }

        $newFilename = uniqid('img_', true) . '.' . $filetype;
        $uploadDir = 'upload/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadPath = $uploadDir . $newFilename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Remove old image file if it exists
            $oldImagePath = $uploadDir . $product['image'];
            if (!empty($product['image']) && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $description, $newFilename, $id);
        } else {
            header("Location: edit.php?id=$id&error=Failed to upload new image");
            exit();
        }
    } else {
        // Keep existing image
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: index.php?success=Product updated successfully");
        exit();
    } else {
        $stmt->close();
        header("Location: edit.php?id=$id&error=Failed to update product");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - CRUD Image Modal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fb 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .preview-img {
            max-height: 200px;
            max-width: 100%;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <div><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-warning text-dark py-3 px-4">
                    <h4 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i> Edit Product
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="edit.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name"
                                   value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <!-- Current Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Image:</label>
                            <div class="text-center p-2 border rounded-3 bg-light">
                                <img src="upload/<?php echo htmlspecialchars($product['image']); ?>"
                                     class="preview-img" alt="Current Image"
                                     onerror="this.src='https://via.placeholder.com/200x150?text=No+Image';">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">New Image <span class="text-muted">(optional)</span></label>
                            <input type="file" class="form-control" id="image" name="image"
                                   accept="image/*" onchange="previewImage(event)">
                            <div class="form-text">Leave empty to keep the current image. Allowed: JPG, JPEG, PNG, GIF, WEBP (Max: 5MB)</div>
                        </div>

                        <!-- New Image Preview -->
                        <div class="mb-3 text-center" id="previewContainer" style="display: none;">
                            <label class="form-label text-success fw-bold d-block mb-2">New Image Preview:</label>
                            <div class="p-2 border rounded-3 bg-light d-inline-block">
                                <img src="" id="imagePreview" class="preview-img" alt="New Preview">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
<?php $conn->close(); ?>
