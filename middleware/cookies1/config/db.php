<?php
// ========================================================
// New Database Configuration: db_auth_cookies
// ========================================================
$host = "localhost";
$user = "root";
$pass = "1234"; // Default password; automatically falls back to empty if needed
$db   = "db_auth_cookies";

// 1. Connect to MySQL server
$conn = @new mysqli($host, $user, $pass);

// If access denied with password '1234', fallback to empty password (standard XAMPP default)
if ($conn->connect_errno == 1045 && $pass !== "") {
    $pass = "";
    $conn = @new mysqli($host, $user, $pass);
}

if ($conn->connect_error) {
    die("<div style='font-family: sans-serif; padding: 20px; background: #fee2e2; color: #991b1b; border-radius: 8px; margin: 20px; max-width: 600px;'>
        <h3 style='margin-top:0;'>Database Connection Failed</h3>
        <p>" . htmlspecialchars($conn->connect_error) . "</p>
        <p style='font-size: 13px; color: #7f1d1d;'>Please ensure your MySQL service is running in XAMPP.</p>
    </div>");
}

// 2. Automatically create new database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($db);

// 3. Automatically create users table if it does not exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `pwd` VARCHAR(255) NOT NULL,
    `roles` ENUM('admin', 'client') NOT NULL DEFAULT 'client',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$conn->query($createTableQuery);

// 4. Automatically seed default demo users if table is empty
$countRes = $conn->query("SELECT COUNT(*) as total FROM `users`");
if ($countRes) {
    $totalUsers = (int)($countRes->fetch_assoc()['total'] ?? 0);
    if ($totalUsers === 0) {
        $defaultPassword = password_hash("123456", PASSWORD_DEFAULT);
        $seedStmt = $conn->prepare("INSERT INTO `users` (`username`, `email`, `pwd`, `roles`) VALUES (?, ?, ?, ?)");
        
        // Seed Administrator account
        $adminName = "System Admin";
        $adminEmail = "admin@example.com";
        $adminRole = "admin";
        $seedStmt->bind_param("ssss", $adminName, $adminEmail, $defaultPassword, $adminRole);
        $seedStmt->execute();

        // Seed Client account
        $clientName = "Demo Client";
        $clientEmail = "client@example.com";
        $clientRole = "client";
        $seedStmt->bind_param("ssss", $clientName, $clientEmail, $defaultPassword, $clientRole);
        $seedStmt->execute();

        $seedStmt->close();
    }
}