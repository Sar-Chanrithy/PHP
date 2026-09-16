<?php
$host = "localhost";
$username = "root";
$password = "1234";
$database = "course_db";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS `$database`");
$conn->select_db($database);

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS `courses` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `image` VARCHAR(255) NOT NULL
)");

// Create uploads folder
if (!is_dir(__DIR__ . '/uploads')) {
    mkdir(__DIR__ . '/uploads', 0777, true);
}
?>
