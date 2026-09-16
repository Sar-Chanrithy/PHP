<?php
include "./config/db.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ./index.php");
    exit();
}

$stmt = $con->prepare("SELECT * FROM tb_subject WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $subject = $result->fetch_assoc();
} else {
    header("Location: ./index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 420px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between">
                    <a href="./index.php" class="btn btn-primary">Back</a>
                    <h1 class="h5 mb-4">Edit Subject</h1>
                </div>
                <form action="./update.php" method="POST" enctype="multipart/form-data" id="createForm" novalidate>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($subject['name']); ?>" placeholder="Enter a name" required>
                        <div class="invalid-feedback">Name is required.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Current Image</label>

                        <?php if (!empty($subject['image']) && file_exists("./upload/image/" . $subject['image'])): ?>
                            <div class="mb-3">
                                <img
                                    src="./upload/image/<?php echo htmlspecialchars($subject['image']); ?>"
                                    alt="Current Image"
                                    width="150"
                                    height="150"
                                    style="object-fit: cover; border-radius: 10px;">
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No image</p>
                        <?php endif; ?>

                        <label for="image" class="form-label">Change Image</label>

                        <input
                            type="file"
                            class="form-control"
                            id="image"
                            name="image"
                            accept="image/*">
                    </div>

                    <button type="submit" name="update" class="btn btn-dark w-100">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('createForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            if (!name.value.trim()) {
                e.preventDefault();
                name.classList.add('is-invalid');
            } else {
                name.classList.remove('is-invalid');
            }
        });
    </script>
</body>

</html>