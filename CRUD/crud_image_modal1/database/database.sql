-- =============================================
-- Database Script for CRUD Image with Modal
-- Database Name: db_crudimagesub
-- =============================================

-- 1. បង្កើត Database (Create Database)
CREATE DATABASE IF NOT EXISTS `db_crudimagesub` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- 2. ប្រើប្រាស់ Database (Select Database)
USE `db_crudimagesub`;

-- 3. បង្កើត Table Products (Create Table)
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
