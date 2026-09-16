<?php
include 'config/db.php';

// Fetch all products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Image with Modal</title>
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
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }
        .card-img-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
            background-color: #f1f3f5;
            cursor: pointer;
        }
        .card-img-wrapper img {
            transition: transform 0.4s ease;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .card-img-wrapper:hover img {
            transform: scale(1.08);
        }
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .card-img-wrapper:hover .image-overlay {
            opacity: 1;
        }
        .modal-img {
            max-width: 100%;
            max-height: 75vh;
            border-radius: 12px;
            object-fit: contain;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .btn-custom {
            border-radius: 10px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
        }
        .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        .preview-modal-img {
            max-height: 180px;
            max-width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary fs-4 d-flex align-items-center" href="index.php">
            <i class="bi bi-images me-2"></i> CRUD Image & Modal
        </a>
        <div class="d-flex gap-2">
            <!-- Button triggers modal or navigates to create page -->
            <button type="button" class="btn btn-primary btn-custom shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-circle me-1"></i> Add New (Modal)
            </button>
            <a href="create.php" class="btn btn-outline-primary btn-custom">
                <i class="bi bi-pencil-square me-1"></i> Add (Page)
            </a>
        </div>
    </div>
</nav>

<div class="container py-3">
    <!-- Success Alert -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div><?php echo htmlspecialchars($_GET['success']); ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Error Alert -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4 rounded-3 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <div><?php echo htmlspecialchars($_GET['error']); ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Product Grid -->
    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card product-card h-100">
                        <div class="card-img-wrapper"
                             onclick="showImage('upload/<?php echo htmlspecialchars($row['image']); ?>', '<?php echo htmlspecialchars(addslashes($row['name'])); ?>')"
                             data-bs-toggle="modal" data-bs-target="#imageModal"
                             title="Click to preview image in modal">
                            <img src="upload/<?php echo htmlspecialchars($row['image']); ?>"
                                 alt="<?php echo htmlspecialchars($row['name']); ?>"
                                 onerror="this.src='https://via.placeholder.com/400x250?text=No+Image';">
                            <div class="image-overlay">
                                <span class="badge bg-dark bg-opacity-75 px-3 py-2 fs-6">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> View Modal
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-dark mb-2">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h5>
                            <p class="card-text text-muted">
                                <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 80, '...')); ?>
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                            <div class="d-flex justify-content-between">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm px-3 fw-semibold">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>"
                                   class="btn btn-danger btn-sm px-3 fw-semibold"
                                   onclick="return confirm('Are you sure you want to delete this item?')">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="text-muted mt-3">No items found</h3>
                <p class="text-muted">Click "Add New" to create your first item.</p>
                <button type="button" class="btn btn-primary btn-custom mt-2" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle me-1"></i> Add New Product
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title fw-bold" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-light">
                <img src="" id="modalImage" class="modal-img" alt="Preview">
            </div>
        </div>
    </div>
</div>

<!-- Create Product Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="createModalLabel">
                    <i class="bi bi-plus-circle me-1"></i> Add New Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="create.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="modal_name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_name" name="name" placeholder="Enter product name" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="modal_description" name="description" rows="3" placeholder="Enter description..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modal_image" class="form-label fw-semibold">Product Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="modal_image" name="image" accept="image/*" onchange="previewModalImage(event)" required>
                        <div class="form-text">Allowed: JPG, JPEG, PNG, GIF, WEBP (Max 5MB)</div>
                    </div>
                    <div class="mb-2 text-center" id="modalPreviewContainer" style="display: none;">
                        <label class="form-label text-primary fw-semibold d-block">Selected Preview:</label>
                        <img src="" id="modalPreviewImage" class="preview-modal-img border p-1 rounded" alt="Preview">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-custom">
                        <i class="bi bi-check-circle-fill me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showImage(src, title) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModalLabel').textContent = title;
    }

    function previewModalImage(event) {
        const file = event.target.files[0];
        const container = document.getElementById('modalPreviewContainer');
        const preview = document.getElementById('modalPreviewImage');
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
