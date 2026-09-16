<?php
include "./config/db.php";

// Fetch all courses
$sql = "SELECT * FROM course ORDER BY id DESC";
$result = $con->query($sql);
$totalCourses = $result ? $result->num_rows : 0;

// Flash messages
$msg = $_GET['msg'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - CRUD with Bootstrap Modal</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --surface-bg: #f8fafc;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 8px -2px rgba(0, 0, 0, 0.03);
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--surface-bg);
            color: #1e293b;
            min-height: 100vh;
        }

        .main-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .app-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .card-header-bar {
            padding: 24px 28px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 700;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .course-thumb {
            width: 72px;
            height: 52px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .course-thumb:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
        }

        .price-badge {
            font-weight: 700;
            font-size: 0.95rem;
            color: #047857;
            background-color: #ecfdf5;
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-block;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-action-edit {
            color: var(--primary-color);
            background-color: #eef2ff;
            border: 1px solid #e0e7ff;
        }

        .btn-action-edit:hover {
            color: #ffffff;
            background-color: var(--primary-color);
        }

        .btn-action-delete {
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
        }

        .btn-action-delete:hover {
            color: #ffffff;
            background-color: #dc2626;
        }

        .preview-box {
            position: relative;
            width: 140px;
            height: 100px;
            border-radius: 10px;
            border: 2px dashed #cbd5e1;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
        }

        .preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 3.5rem;
            color: #94a3b8;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>

    <div class="main-container">
        <!-- Toast / Alerts -->
        <?php if ($msg === 'created'): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Course has been successfully added!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($msg === 'updated'): ?>
            <div class="alert alert-primary alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Course has been successfully updated!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-trash-fill me-2"></i> Course was successfully deleted.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Error: <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Main Card -->
        <div class="app-card">
            <!-- Header Bar -->
            <div class="card-header-bar d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="h4 fw-bold mb-1">Course Catalog</h1>
                    <p class="text-muted small mb-0">Manage your courses, prices, and preview images with modal windows</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-secondary-subtle text-secondary-emphasis px-3 py-2 rounded-pill fs-7">
                        Total: <strong><?php echo $totalCourses; ?></strong> Courses
                    </span>
                    <button type="button" class="btn btn-primary-custom d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                        <i class="bi bi-plus-lg fs-6"></i> Add Course
                    </button>
                </div>
            </div>

            <!-- Table or Empty State -->
            <div class="table-responsive">
                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th style="width: 70px;">#</th>
                                <th style="width: 110px;">Image</th>
                                <th>Course Name</th>
                                <th style="width: 150px;">Price</th>
                                <th style="width: 160px;">Created At</th>
                                <th style="width: 120px;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            while ($row = $result->fetch_assoc()): 
                                $hasImage = !empty($row['image']) && file_exists("./upload/course/" . $row['image']);
                                $imagePath = $hasImage 
                                    ? "./upload/course/" . htmlspecialchars($row['image']) 
                                    : "https://placehold.co/120x80/e2e8f0/64748b?text=No+Image";
                            ?>
                                <tr>
                                    <td class="text-muted fw-semibold"><?php echo $no++; ?></td>
                                    <td>
                                        <img src="<?php echo $imagePath; ?>" 
                                             alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                             class="course-thumb"
                                             data-bs-toggle="modal"
                                             data-bs-target="#imagePreviewModal"
                                             data-img-src="<?php echo $imagePath; ?>"
                                             data-img-title="<?php echo htmlspecialchars($row['name']); ?>"
                                             title="Click to view full image">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6"><?php echo htmlspecialchars($row['name']); ?></div>
                                        <span class="text-muted small">Course ID: #<?php echo $row['id']; ?></span>
                                    </td>
                                    <td>
                                        <span class="price-badge">
                                            $<?php echo number_format($row['price'], 2); ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        <?php echo !empty($row['created_at']) ? date("M d, Y", strtotime($row['created_at'])) : '-'; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-2">
                                            <!-- Edit Button -->
                                            <button type="button" 
                                                    class="btn-action btn-action-edit edit-btn"
                                                    title="Edit Course"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCourseModal"
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                                    data-price="<?php echo htmlspecialchars($row['price']); ?>"
                                                    data-image="<?php echo htmlspecialchars($row['image'] ?? ''); ?>"
                                                    data-imgsrc="<?php echo $imagePath; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" 
                                                    class="btn-action btn-action-delete delete-btn" 
                                                    title="Delete Course"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCourseModal"
                                                    data-id="<?php echo $row['id']; ?>"
                                                    data-name="<?php echo htmlspecialchars($row['name']); ?>">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon"><i class="bi bi-folder-x"></i></div>
                        <h5 class="fw-bold text-dark">No courses found</h5>
                        <p class="text-muted mb-3">You haven't created any courses yet. Get started by clicking the button below.</p>
                        <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                            <i class="bi bi-plus-lg me-1"></i> Add First Course
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL 1: ADD COURSE ==================== -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="./store.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="addCourseModalLabel">
                            <i class="bi bi-plus-circle-fill text-primary me-2"></i>Add New Course
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_name" class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_name" name="name" placeholder="e.g. Mastering Python for Data Science" required>
                        </div>

                        <div class="mb-3">
                            <label for="add_price" class="form-label fw-semibold">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="add_price" name="price" placeholder="99.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="add_image" class="form-label fw-semibold">Course Image</label>
                            <input type="file" class="form-control" id="add_image" name="image" accept="image/*">
                            <div class="form-text">Formats accepted: JPG, PNG, WEBP, GIF.</div>
                        </div>

                        <!-- Live Image Preview -->
                        <div id="addPreviewWrapper" class="mb-2" style="display: none;">
                            <label class="form-label small text-muted">Selected Image Preview:</label>
                            <div class="preview-box">
                                <img id="addPreviewImg" src="" alt="Preview">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="save" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i> Save Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL 2: EDIT COURSE ==================== -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="./update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="editCourseModalLabel">
                            <i class="bi bi-pencil-square text-primary me-2"></i>Edit Course
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_price" class="form-label fw-semibold">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="edit_price" name="price" required>
                            </div>
                        </div>

                        <!-- Current Image Display -->
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Current Image:</label>
                            <div class="preview-box">
                                <img id="edit_current_preview" src="" alt="Current Course Image">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_image" class="form-label fw-semibold">Change Image (Optional)</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                            <div class="form-text">Upload only if you want to replace the current image.</div>
                        </div>

                        <!-- New Selected Image Preview -->
                        <div id="editNewPreviewWrapper" class="mb-2" style="display: none;">
                            <label class="form-label small text-muted">New Image Preview:</label>
                            <div class="preview-box">
                                <img id="editNewPreviewImg" src="" alt="New Preview">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i> Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL 3: FULL IMAGE PREVIEW ==================== -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0 text-white">
                    <h6 class="modal-title" id="lightboxTitle">Course Image</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="lightboxImg" src="" alt="Course Image" class="img-fluid rounded-3" style="max-height: 75vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL 4: DELETE CONFIRMATION ==================== -->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="text-danger mb-3">
                        <i class="bi bi-exclamation-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Are you sure?</h5>
                    <p class="text-muted small mb-4">
                        Do you really want to delete <strong id="deleteCourseName" class="text-dark">this course</strong>? This action cannot be undone.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                        <a href="#" id="confirmDeleteBtn" class="btn btn-danger px-3">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Add Image Live Preview
        const addImageInput = document.getElementById('add_image');
        const addPreviewWrapper = document.getElementById('addPreviewWrapper');
        const addPreviewImg = document.getElementById('addPreviewImg');

        addImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    addPreviewImg.src = e.target.result;
                    addPreviewWrapper.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                addPreviewWrapper.style.display = 'none';
                addPreviewImg.src = '';
            }
        });

        // 2. Edit Modal Data Population
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const imgSrc = this.getAttribute('data-imgsrc');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_current_preview').src = imgSrc;

                // Reset new image file input and preview
                document.getElementById('edit_image').value = '';
                document.getElementById('editNewPreviewWrapper').style.display = 'none';
                document.getElementById('editNewPreviewImg').src = '';
            });
        });

        // 3. Edit Modal: Live preview for new selected image
        const editImageInput = document.getElementById('edit_image');
        const editNewPreviewWrapper = document.getElementById('editNewPreviewWrapper');
        const editNewPreviewImg = document.getElementById('editNewPreviewImg');

        editImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    editNewPreviewImg.src = e.target.result;
                    editNewPreviewWrapper.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                editNewPreviewWrapper.style.display = 'none';
                editNewPreviewImg.src = '';
            }
        });

        // 4. Lightbox Image Preview Modal
        const previewImages = document.querySelectorAll('.course-thumb');
        previewImages.forEach(img => {
            img.addEventListener('click', function() {
                const src = this.getAttribute('data-img-src');
                const title = this.getAttribute('data-img-title');
                document.getElementById('lightboxImg').src = src;
                document.getElementById('lightboxTitle').textContent = title || 'Course Image';
            });
        });

        // 5. Delete Confirmation Modal
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                document.getElementById('deleteCourseName').textContent = `"${name}"`;
                document.getElementById('confirmDeleteBtn').href = `./delete.php?id=${encodeURIComponent(id)}`;
            });
        });
    </script>
</body>

</html>
