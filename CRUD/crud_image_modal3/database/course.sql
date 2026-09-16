-- 1. Create Database if not exists
CREATE DATABASE IF NOT EXISTS `db_crudimagesub` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- 2. Select Database
USE `db_crudimagesub`;

-- 3. Create Table `course`
CREATE TABLE IF NOT EXISTS `course` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `image` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Sample Course Records (Optional)
INSERT INTO `course` (`name`, `price`, `image`) VALUES
('Web Development with PHP & MySQL', 120.00, NULL),
('Fullstack React & Node.js Masterclass', 150.00, NULL),
('UI/UX Design with Figma', 95.00, NULL);
