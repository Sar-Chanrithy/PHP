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
    </style>
</head>

<body>
    <div class="container page-wrap">
        <div class="card card-custom">
            <div class="card-header card-header-custom d-flex justify-content-between align-items-center p-3">
                <h4 class="mb-0"><i class="bi bi-journal-bookmark-fill me-2"></i>Subjects</h4>
                <a href="./create.php" class="btn btn-add">
                    <i class="bi bi-plus-lg me-1"></i> Add Subject
                </a>
            </div>
            <div class="card-body p-0">
                <?php
                $data = "SELECT * FROM tb_subject ORDER BY id DESC";
                $resule = $con->query($data);

                if ($resule && $resule->num_rows > 0) {
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
                            while ($row = $resule->fetch_assoc()) {
                                $imagePath = !empty($row['image']) && file_exists("./upload/image/" . $row['image']) 
                                    ? "./upload/image/" . htmlspecialchars($row['image']) 
                                    : "https://placehold.co/120x80?text=No+Image";
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><p class='subject-name'><?php echo htmlspecialchars($row['name']); ?></p></td>
                                    <td><img width='120px' height='70px' style='object-fit: cover; border-radius: 6px;' src='<?php echo $imagePath; ?>' alt=''></td>
                                    <td class='text-end-actions'>
                                        <a href='./edit.php?id=<?php echo $row['id']; ?>' class='btn btn-icon btn-outline-primary btn-sm' title='Edit'>
                                            <i class='bi bi-pencil-square'></i>
                                        </a>
                                        <a href='./delete.php?id=<?php echo $row['id']; ?>' class='btn btn-icon btn-outline-danger btn-sm' title='Delete' onclick="return confirm('Delete this item?');">
                                            <i class='bi bi-trash3'></i>
                                        </a>
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
</body>

</html>