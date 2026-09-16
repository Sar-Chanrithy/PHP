<?php
include 'config/db.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: index.php?error=Invalid item ID");
    exit();
}
// Fetch the product to get the image filename
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: index.php?error=Item not found");
    exit();
}
$product = $result->fetch_assoc();
$stmt->close();
// Delete the image file
$imagePath = 'upload/' . $product['image'];
if (file_exists($imagePath)) {
    unlink($imagePath);
}
// Delete from database
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: index.php?success=Item deleted successfully");
} else {
    header("Location: index.php?error=Failed to delete item");
}
$stmt->close();
$conn->close();
exit();
?>
