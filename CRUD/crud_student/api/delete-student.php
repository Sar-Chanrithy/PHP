<?php
require_once __DIR__ . '/../db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>