<?php
// Database Configuration
$host = "localhost";
$user = "root";
$passwords = ["1234", ""]; // Check '1234' first, then empty password
$dbname = "db_crudimagesub";

$con = null;
$connected = false;

// Try connecting to MySQL
foreach ($passwords as $pwd) {
    try {
        $con = @new mysqli($host, $user, $pwd);
        if (!$con->connect_error) {
            $connected = true;
            break;
        }
    } catch (\Throwable $e) {
        continue;
    }
}

if (!$connected || !$con) {
    die("Database connection failed: Could not connect to MySQL server with provided credentials.");
}

// Create database if not exists and select it
$con->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$con->select_db($dbname);

// Ensure the `course` table exists
$tableSql = "CREATE TABLE IF NOT EXISTS `course` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `image` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$con->query($tableSql);
?>
