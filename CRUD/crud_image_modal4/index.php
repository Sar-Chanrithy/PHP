<?php
require_once 'db.php';

// Insert Course
if (isset($_POST['btn_save'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $image_name = time() . '_' . $image;

    move_uploaded_file($tmp_name, 'uploads/' . $image_name);

    $sql = "INSERT INTO courses (name, price, image) VALUES ('$name', '$price', '$image_name')";
    $conn->query($sql);

    header("Location: index.php");
    exit;
}

// Delete Course
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $res = $conn->query("SELECT image FROM courses WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        @unlink('uploads/' . $row['image']);
    }

    $conn->query("DELETE FROM courses WHERE id = $id");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course CRUD</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Course List</h2>

    <!-- Button trigger 1 modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        + Add Course
    </button>

    <!-- Course Table -->
    <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM courses ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td>
                    <img src="uploads/<?= $row['image'] ?>" width="80" height="80" class="rounded object-fit-cover" alt="Course Image">
                </td>
                <td>
                    <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                </td>
            </tr>
            <?php 
                endwhile;
            else:
            ?>
            <tr>
                <td colspan="5" class="text-center py-4">No courses available.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Include 1 Modal from create.php -->
<?php include 'create.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
