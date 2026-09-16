<?php require 'config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Image CRUD</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <h2>Product List</h2>
    <a href="create.php" class="btn btn-success">Add New Product</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td><img src='upload/product/" . htmlspecialchars($row['image']) . "'></td>";
            echo "<td>
                    <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                    <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>