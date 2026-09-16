<?php
include "./config/db.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        body {
            background: #f4f6f9;
        }

        .page-wrap {
            max-width: 900px;
            margin: 40px auto;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #4b71df, #315ade);
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1rem rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-custom thead {
            background: #f8f9fc;
        }

        .table-custom th {
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #edf2f7;
            padding: 14px 20px;
        }

        .table-custom td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #edf2f7;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover {
            background-color: #f8f9fc;
        }

        .subject-name {
            font-weight: 500;
            color: #2d3748;
            margin: 0;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .btn-add {
            background: #4b71df;
            border: none;
            color: #fff;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 16px;
        }

        .btn-add:hover {
            background: #315ade;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #a0aec0;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 16px;
            display: block;
        }

        .text-end-actions {
            text-align: right;
            width: 1%;
            white-space: nowrap;
        }

        .img-thumb-preview {
            width: 120px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .img-thumb-preview:hover {
            transform: scale(1.04);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        /* ==================== MODAL STYLES ==================== */
        .modal-content-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header-custom-blue {
            background: linear-gradient(135deg, #4b71df, #315ade);
            color: #ffffff;
            padding: 16px 24px;
            border-bottom: none;
        }

        .modal-header-custom-blue .modal-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .modal-header-custom-blue .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.85;
        }

        .modal-header-custom-blue .btn-close:hover {
            opacity: 1;
        }

        .modal-body-custom {
            padding: 24px;
            background: #ffffff;
        }

        .modal-footer-custom {
            padding: 14px 24px;
            background: #f8fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .form-label-custom {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .form-control-custom {
            border: 1px solid #d2d6dc;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: #4b71df;
            box-shadow: 0 0 0 3px rgba(75, 113, 223, 0.15);
        }

        /* Current Image Preview Box */
        .preview-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            padding: 14px;
            text-align: center;
            margin-bottom: 14px;
        }

        .preview-box img {
            max-height: 120px;
            border-radius: 8px;
            object-fit: contain;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Delete Confirmation Dialog */
        .delete-dialog-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
            text-align: center;
            padding: 28px 24px;
        }

        .delete-dialog-icon {
            font-size: 3.5rem;
            color: #ef4444;
            margin-bottom: 12px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container page-wrap">
        <div class="card card-custom">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center p-3">
                <h4 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>Subjects</h4>
                <!-- Add Subject Button triggers Add Modal -->
                <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg me-1"></i> Add Subject
                </button>
            </div>
            <div class="card-body p-0">
                <?php
                $data = "SELECT * FROM tb_subject ORDER BY id DESC";
                $resule = $con->query($data);
                $subjects = [];
                if ($resule && $resule->num_rows > 0) {
                    while ($r = $resule->fetch_assoc()) {
                        $subjects[] = $r;
                    }
                }

                if (!empty($subjects)) {
                ?>
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject Name</th>
                                <th>Image</th>
                                <th class="text-end-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($subjects as $row) {
                                $imagePath = !empty($row['image']) && file_exists("./upload/image/" . $row['image']) 
                                    ? "./upload/image/" . htmlspecialchars($row['image']) 
                                    : "https://placehold.co/120x80?text=No+Image";
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><p class='subject-name'><?php echo htmlspecialchars($row['name']); ?></p></td>
                                    <td>
                                        <!-- Click Image thumbnail to open Image Preview Modal -->
                                        <img class='img-thumb-preview' 
                                             src='<?php echo $imagePath; ?>' 
                                             alt='Image' 
                                             title='Click to view full image'
                                             data-bs-toggle='modal' 
                                             data-bs-target='#imageModal<?php echo $row['id']; ?>'>
                                    </td>
                                    <td class='text-end-actions'>
                                        <!-- View Details Button -->
                                        <button type='button' 
                                                class='btn btn-icon btn-outline-info btn-sm' 
                                                title='View Details'
                                                data-bs-toggle='modal' 
                                                data-bs-target='#viewModal<?php echo $row['id']; ?>'>
                                            <i class='bi bi-eye'></i>
                                        </button>

                                        <!-- Edit Button (Opens Edit Modal) -->
                                        <button type='button' 
                                                class='btn btn-icon btn-outline-primary btn-sm' 
                                                title='Edit'
                                                data-bs-toggle='modal' 
                                                data-bs-target='#editModal<?php echo $row['id']; ?>'>
                                            <i class='bi bi-pencil-square'></i>
                                        </button>

                                        <!-- Delete Button (Opens Delete Confirmation Modal) -->
                                        <button type='button' 
                                                class='btn btn-icon btn-outline-danger btn-sm' 
                                                title='Delete'
                                                data-bs-toggle='modal' 
                                                data-bs-target='#deleteModal<?php echo $row['id']; ?>'>
                                            <i class='bi bi-trash3'></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0">No subjects found. Start by adding one.</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- ==================== MODALS ==================== -->

    <!-- 1. Add Subject Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom-blue">
                    <h5 class="modal-title" id="addModalLabel">
                        <i class="bi bi-plus-circle me-1"></i> Add Subject
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./store.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body modal-body-custom">
                        <div class="mb-3">
                            <label for="add_name" class="form-label form-label-custom">Subject Name</label>
                            <input type="text" class="form-control form-control-custom" id="add_name" name="name" placeholder="Enter subject name" required>
                        </div>

                        <div class="mb-3">
                            <label for="add_image" class="form-label form-label-custom">Subject Image</label>
                            <input type="file" class="form-control form-control-custom" id="add_image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-custom">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="save" class="btn btn-add px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if (!empty($subjects)) {
        foreach ($subjects as $row) {
            $imagePath = !empty($row['image']) && file_exists("./upload/image/" . $row['image']) 
                ? "./upload/image/" . htmlspecialchars($row['image']) 
                : "https://placehold.co/120x80?text=No+Image";
    ?>
        <!-- View Details Modal for Subject #<?php echo $row['id']; ?> -->
        <div class="modal fade text-start" id="viewModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header modal-header-custom-blue">
                        <h5 class="modal-title" id="viewModalLabel<?php echo $row['id']; ?>">
                            <i class="bi bi-info-circle me-1"></i> Subject Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body modal-body-custom">
                        <div class="text-center mb-3">
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-height: 180px; width: 100%; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        </div>
                        <ul class="list-group list-group-flush border rounded-3 overflow-hidden">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted small fw-semibold">Subject ID</span>
                                <span class="badge bg-primary rounded-pill">#<?php echo $row['id']; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted small fw-semibold">Subject Name</span>
                                <span class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                <span class="text-muted small fw-semibold">Image File</span>
                                <span class="small text-truncate" style="max-width: 220px;"><?php echo !empty($row['image']) ? htmlspecialchars($row['image']) : '<em class="text-muted">None</em>'; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer modal-footer-custom">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-add px-3" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Edit Modal for Subject #<?php echo $row['id']; ?> -->
        <div class="modal fade text-start" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header modal-header-custom-blue">
                        <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">
                            <i class="bi bi-pencil-square me-1"></i> Edit Subject
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="./update.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body modal-body-custom">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label form-label-custom">Subject Name</label>
                                <input type="text" class="form-control form-control-custom" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Enter subject name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label form-label-custom d-block">Current Image</label>
                                <div class="preview-box">
                                    <?php if (!empty($row['image']) && file_exists("./upload/image/" . $row['image'])): ?>
                                        <img src="<?php echo $imagePath; ?>" alt="Current Image">
                                    <?php else: ?>
                                        <p class="text-muted mb-0 small">No image uploaded</p>
                                    <?php endif; ?>
                                </div>
                                <label class="form-label form-label-custom">Change Image</label>
                                <input type="file" class="form-control form-control-custom" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer modal-footer-custom">
                            <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="update" class="btn btn-add px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 3. Delete Confirmation Modal for Subject #<?php echo $row['id']; ?> -->
        <div class="modal fade text-start" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content delete-dialog-content">
                    <div class="modal-body p-0">
                        <i class="bi bi-exclamation-triangle-fill delete-dialog-icon"></i>
                        <h5 class="fw-bold mb-2">Delete Subject?</h5>
                        <p class="text-muted small mb-0">Are you sure you want to delete <strong class="text-dark"><?php echo htmlspecialchars($row['name']); ?></strong>?</p>
                    </div>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                        <a href="./delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger px-3">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Image Preview Modal for Subject #<?php echo $row['id']; ?> -->
        <div class="modal fade" id="imageModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content modal-content-custom">
                    <div class="modal-header modal-header-custom-blue">
                        <h5 class="modal-title">
                            <i class="bi bi-image me-1"></i> <?php echo htmlspecialchars($row['name']); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 text-center bg-dark">
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 100%; max-height: 75vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    <?php
        }
    }
    ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>