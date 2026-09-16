<?php
include "./config/db.php";

if (!isset($_POST['update'])) {
    header("Location: ./index.php");
    exit;
}

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');

if ($id === null || $name === '') {
    header("Location: ./index.php");
    exit;
}

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $oldResult = $con->query("SELECT image FROM tb_subject WHERE id = '$id'");
    $oldImage = ($oldResult && $oldResult->num_rows > 0) ? $oldResult->fetch_assoc()['image'] : null;

    $imageName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $extension = pathinfo($imageName, PATHINFO_EXTENSION);
    $imageNew = uniqid() . "." . $extension;

    move_uploaded_file($tmp, "./upload/image/" . $imageNew);

    if ($oldImage && file_exists("./upload/image/" . $oldImage)) {
        unlink("./upload/image/" . $oldImage);
    }

    $sql = "UPDATE tb_subject SET name = '$name', image = '$imageNew' WHERE id = '$id'";
} else {
    $sql = "UPDATE tb_subject SET name = '$name' WHERE id = '$id'";
}

if ($con->query($sql)) {
    header("Location: ./index.php");
    exit;
}

echo "Database error: " . $con->error;