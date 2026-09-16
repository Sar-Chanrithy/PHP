<?php
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO students(name, gender, dob, email, phone, major)
            VALUES(?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $_POST['name'],
            $_POST['gender'],
            $_POST['dob'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['major']
        ]);

        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        // if error code 23000 (Duplicate entry)
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
}
?>