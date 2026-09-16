<?php
if (file_exists('config/db.php')) {
    require 'config/db.php';
} elseif (file_exists('congfig/db.php')) {
    require 'congfig/db.php';
} else {
    die("Database configuration file not found.");
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalProducts = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image CRUD with Modal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>

<div class="crud-container">
    <!-- Alert Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>Product has been <strong>successfully added</strong>!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['msg'] === 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>Product has been <strong>successfully updated</strong>!</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['msg'] === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-trash-fill me-2 fs-5"></i>
                <div>Product has been <strong>deleted</strong>.</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div>
                <?php
                $err = $_GET['error'];
                if ($err === 'empty_name') echo "Product name cannot be empty.";
                elseif ($err === 'no_image') echo "Please select an image to upload.";
                elseif ($err === 'upload_failed') echo "Failed to upload image file.";
                else echo "An error occurred. Please try again.";
                ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="main-card">
        <!-- Card Header -->
        <div class="card-header-custom">
            <div>
                <h2>
                    <i class="bi bi-images text-primary"></i> Product List
                    <span class="badge bg-light text-dark fs-6 border ms-2"><?php echo $totalProducts; ?> items</span>
                </h2>
                <small class="text-muted">Manage your product records and images with modal dialogs</small>
            </div>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-1"></i> Add New Product
            </button>
        </div>

        <!-- Table Container -->
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th style="width: 90px;">ID</th>
                        <th>Product Name</th>
                        <th style="width: 140px;">Image</th>
                        <th style="width: 180px;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($totalProducts > 0): ?>
                        <?php foreach ($products as $row): ?>
                            <?php 
                                $imageFile = !empty($row['image']) ? 'upload/product/' . $row['image'] : '';
                                $hasImage = !empty($row['image']) && file_exists($imageFile);
                                $imgSrc = $hasImage ? $imageFile : 'https://placehold.co/100x100?text=No+Image';
                            ?>
                            <tr>
                                <td>
                                    <span class="badge-id">#<?php echo $row['id']; ?></span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark"><?php echo htmlspecialchars($row['name']); ?></span>
                                </td>
                                <td>
                                    <div class="table-img-wrapper" 
                                         onclick="openImageModal('<?php echo htmlspecialchars($imgSrc, ENT_QUOTES); ?>', '<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>')"
                                         title="Click to preview image">
                                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                                             alt="<?php echo htmlspecialchars($row['name']); ?>"
                                             onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                        <div class="table-img-overlay">
                                            <i class="bi bi-zoom-in"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-action edit-btn me-1"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>"
                                            data-image="<?php echo htmlspecialchars($row['image'], ENT_QUOTES); ?>"
                                            data-imgsrc="<?php echo htmlspecialchars($imgSrc, ENT_QUOTES); ?>"
                                            title="Edit Product">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-action delete-btn"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-name="<?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?>"
                                            title="Delete Product">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                    <h5>No products found</h5>
                                    <p class="mb-3">Start by adding your first product with an image.</p>
                                    <button type="button" class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                                        <i class="bi bi-plus-lg me-1"></i> Add Product
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. ADD PRODUCT MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold" id="addModalLabel">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="store.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="add_name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="add_name" name="name" placeholder="Enter product name..." required>
                    </div>

                    <div class="mb-3">
                        <label for="add_image" class="form-label fw-semibold">Product Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="add_image" name="image" accept="image/*" onchange="previewAddImage(event)" required>
                        <div class="form-text">Choose an image (JPG, PNG, GIF, WEBP).</div>
                    </div>

                    <!-- Add Preview Box -->
                    <div id="addPreviewBox" class="preview-box" style="display: none;">
                        <small class="text-muted d-block mb-2">Selected Image Preview:</small>
                        <img id="addImagePreview" src="" alt="Preview">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. EDIT PRODUCT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold" id="editModalLabel">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="old_image" id="edit_old_image">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <!-- Current Image Preview -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Current Image:</label>
                        <div class="preview-box">
                            <img id="edit_current_preview" src="" alt="Current Image">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label fw-semibold">New Image <span class="text-muted fw-normal">(Optional)</span></label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewEditImage(event)">
                        <div class="form-text">Leave blank to keep the current image.</div>
                    </div>

                    <!-- New Image Preview Box -->
                    <div id="editNewPreviewBox" class="preview-box" style="display: none;">
                        <small class="text-success d-block mb-2 fw-semibold">New Image Preview:</small>
                        <img id="editNewImagePreview" src="" alt="New Preview">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. IMAGE PREVIEW MODAL -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title fw-bold" id="imageModalTitle">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-light">
                <img src="" id="modalImageLarge" class="modal-preview-large" alt="Full Preview">
            </div>
        </div>
    </div>
</div>

<!-- 4. DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3">
            <div class="modal-body">
                <div class="text-danger mb-3">
                    <i class="bi bi-exclamation-circle" style="font-size: 3.5rem;"></i>
                </div>
                <h5 class="fw-bold mb-2">Delete Product?</h5>
                <p class="text-muted small mb-0">Are you sure you want to delete <strong id="delete_product_title"></strong>? This action cannot be undone.</p>
            </div>
            <div class="d-flex justify-content-center gap-2 p-2">
                <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDeleteLink" class="btn btn-danger px-3">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Live preview for Add Product Image
    function previewAddImage(event) {
        const file = event.target.files[0];
        const previewBox = document.getElementById('addPreviewBox');
        const previewImg = document.getElementById('addImagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewBox.style.display = 'none';
        }
    }

    // Live preview for Edit Product Image
    function previewEditImage(event) {
        const file = event.target.files[0];
        const previewBox = document.getElementById('editNewPreviewBox');
        const previewImg = document.getElementById('editNewImagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewBox.style.display = 'none';
        }
    }

    // Open Image Modal
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    function openImageModal(src, title) {
        document.getElementById('modalImageLarge').src = src;
        document.getElementById('imageModalTitle').textContent = title || 'Image Preview';
        imageModal.show();
    }

    // Edit Product Modal Handler
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const image = this.getAttribute('data-image');
            const imgSrc = this.getAttribute('data-imgsrc');

            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_old_image').value = image;
            document.getElementById('edit_current_preview').src = imgSrc;

            // Reset new image input & preview
            document.getElementById('edit_image').value = '';
            document.getElementById('editNewPreviewBox').style.display = 'none';

            editModal.show();
        });
    });

    // Delete Confirmation Modal Handler
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete_product_title').textContent = '"' + name + '"';
            document.getElementById('confirmDeleteLink').href = 'delete.php?id=' + id;

            deleteModal.show();
        });
    });
</script>

</body>
</html>