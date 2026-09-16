-- ========================================================
-- Database Setup Script for Cookie-based Auth System
-- ========================================================

-- 1. Create the Database
CREATE DATABASE IF NOT EXISTS `db_auth_cookies` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `db_auth_cookies`;

-- 2. Create the Users Table
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `pwd` VARCHAR(255) NOT NULL,
    `roles` ENUM('admin', 'client') NOT NULL DEFAULT 'client',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Insert Default Demo Accounts (Password for both is: 123456)
-- Bcrypt hash for '123456' generated via password_hash('123456', PASSWORD_DEFAULT)
INSERT INTO `users` (`username`, `email`, `pwd`, `roles`) VALUES
('Admin User', 'admin@example.com', '$2y$10$w3Oa2xH0L8UuWq4E7e7h6.p3wG0u3u6bB8V4U9iO5c1W4r2y9O6Gy', 'admin'),
('John Client', 'client@example.com', '$2y$10$w3Oa2xH0L8UuWq4E7e7h6.p3wG0u3u6bB8V4U9iO5c1W4r2y9O6Gy', 'client')
ON DUPLICATE KEY UPDATE `email` = `email`;
