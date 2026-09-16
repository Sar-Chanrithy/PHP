<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // Validate inputs
    if (empty($name)) {
        header("Location: create.php?error=Name is required");
        exit();
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filesize = $_FILES['image']['size'];

        // Validate file type
        if (!in_array($filetype, $allowed)) {
            header("Location: create.php?error=Only JPG, JPEG, PNG, GIF, and WEBP files are allowed");
            exit();
        }

        // Validate file size (max 5MB)
        if ($filesize > 5 * 1024 * 1024) {
            header("Location: create.php?error=File size must be less than 5MB");
            exit();
        }

        // Generate unique filename
        $newFilename = uniqid('img_', true) . '.' . $filetype;
        $uploadDir = 'upload/';

        // Create upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadPath = $uploadDir . $newFilename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO products (name, description, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $description, $newFilename);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: index.php?success=Product created successfully");
                exit();
            } else {
                $stmt->close();
                header("Location: create.php?error=Failed to insert into database");
                exit();
            }
        } else {
            header("Location: create.php?error=Failed to upload image");
            exit();
        }
    } else {
        header("Location: create.php?error=Please select an image");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - CRUD Image Modal</title>
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
        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            border-color: #0d6efd;
        }
        .preview-img {
            max-height: 220px;
            max-width: 100%;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .btn-custom {
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-custom:hover {
            transform: translateY(-1px);
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
                <div class="card-header">
                    <h4 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-plus-circle-fill me-2"></i> Add New Product
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter product name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter product description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">Product Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)" required>
                            <div class="form-text">Supported: JPG, JPEG, PNG, GIF, WEBP (Max 5MB)</div>
                        </div>

                        <!-- Image Preview Box -->
                        <div class="mb-4 text-center" id="previewContainer" style="display: none;">
                            <label class="form-label fw-semibold text-primary d-block mb-2">Image Preview:</label>
                            <div class="p-2 border rounded-3 bg-light d-inline-block">
                                <img src="" id="imagePreview" class="preview-img" alt="Preview">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="index.php" class="btn btn-outline-secondary btn-custom">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary btn-custom">
                                <i class="bi bi-check-circle-fill me-1"></i> Save Product
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