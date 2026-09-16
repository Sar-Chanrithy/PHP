<?php
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $stmt = $pdo->prepare("
            UPDATE students 
            SET name = ?, gender = ?, dob = ?, email = ?, phone = ?, major = ? 
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['gender'],
            $_POST['dob'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['major'],
            $_POST['id']
        ]);

        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>
                alert('អ៊ីមែលនេះមានក្នុងប្រព័ន្ធរួចហើយ! សូមប្រើអ៊ីមែលផ្សេង។');
                window.history.back();
            </script>";
            exit;
        } else {
            die("Error: " . $e->getMessage());
        }
    }
}
?>