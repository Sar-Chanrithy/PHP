<?php
include "./config/db.php";

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($id) {
    $id = intval($id);
    $uploadDir = "./upload/course/";

    // 1. Fetch old image to delete from disk
    $stmtOld = $con->prepare("SELECT image FROM course WHERE id = ?");
    $stmtOld->bind_param("i", $id);
    $stmtOld->execute();
    $result = $stmtOld->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image']) && file_exists($uploadDir . $row['image'])) {
            unlink($uploadDir . $row['image']);
        }
    }

    // 2. Delete the record from database
    $stmtDelete = $con->prepare("DELETE FROM course WHERE id = ?");
    $stmtDelete->bind_param("i", $id);
    $stmtDelete->execute();

    header("Location: ./index.php?msg=deleted");
    exit();
}

header("Location: ./index.php");
exit();
?>
