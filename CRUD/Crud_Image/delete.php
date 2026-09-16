<?php
include "./config/db.php";

$id = $_GET['id'] ?? null;

if ($id) {
    // delete photos from folder
    $stmtOld = $con->prepare("SELECT image FROM tb_subject WHERE id = ?");
    $stmtOld->bind_param("i", $id);
    $stmtOld->execute();
    $result = $stmtOld->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!empty($row['image']) && file_exists("./upload/image/" . $row['image'])) {
            unlink("./upload/image/" . $row['image']);
        }
    }

    // delete data from table
    $stmtDelete = $con->prepare("DELETE FROM tb_subject WHERE id = ?");
    $stmtDelete->bind_param("i", $id);
    $stmtDelete->execute();
}

header("Location: ./index.php");
exit();
?>