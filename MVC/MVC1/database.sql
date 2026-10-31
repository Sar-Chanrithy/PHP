-- ===================================================
-- Database setup for MVC Product Catalog
-- ===================================================

-- 1. Create database if it does not exist
CREATE DATABASE IF NOT EXISTS `mvc_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- 2. Switch to the database
USE `mvc_db`;

-- 3. Create products table (with image column)
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `description` TEXT,
    `image` VARCHAR(500) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ensure image column exists if table was created previously without it
SET @dbname = DATABASE();
SET @tablename = "products";
SET @columnname = "image";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE products ADD COLUMN image VARCHAR(500) NULL AFTER description"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 4. Seed 10 computer products with pictures
INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `description`, `image`) VALUES
(1, 'Apple MacBook Pro 16" (M3 Max)', 'Laptops', 3499.00, 10, 'Apple M3 Max chip with 16-core CPU, 40-core GPU, 48GB unified memory, 1TB SSD, and 16.2-inch Liquid Retina XDR display.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80'),
(2, 'Dell XPS 15 (9530)', 'Laptops', 1899.00, 15, '15.6-inch 3.5K OLED touchscreen, Intel Core i7-13700H, 32GB DDR5 RAM, 1TB NVMe SSD, and NVIDIA GeForce RTX 4060 graphics.', 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80'),
(3, 'ASUS ROG Zephyrus G16', 'Gaming Laptops', 2199.00, 12, '16-inch 2.5K 240Hz OLED ROG Nebula display, Intel Core Ultra 9 185H, 32GB LPDDR5X, 1TB SSD, and NVIDIA GeForce RTX 4080.', 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80'),
(4, 'Lenovo ThinkPad X1 Carbon Gen 12', 'Business Laptops', 1599.00, 20, 'Ultralight carbon-fiber chassis, Intel Core Ultra 7 155H, 16GB RAM, 512GB SSD, legendary ThinkPad keyboard, and all-day battery.', 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80'),
(5, 'HP OMEN 45L Gaming Desktop', 'Desktop Computers', 2499.00, 8, 'Extreme gaming desktop with patented Cryo Chamber cooling, Intel Core i9-14900K, 64GB DDR5, 2TB SSD, and NVIDIA RTX 4080 Super.', 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80'),
(6, 'Apple iMac 24" 4.5K (M3)', 'All-in-One PC', 1399.00, 14, 'Vibrant ultra-thin all-in-one desktop featuring 4.5K Retina display, Apple M3 8-core CPU, 8-core GPU, 16GB RAM, and 512GB SSD.', 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80'),
(7, 'Acer Predator Helios 18', 'Gaming Laptops', 2299.00, 7, '18-inch Mini LED 250Hz display, Intel Core i9-14900HX, 32GB DDR5, 1TB PCIe Gen4 SSD, and NVIDIA GeForce RTX 4080 12GB.', 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=800&q=80'),
(8, 'Alienware Aurora R16 Gaming PC', 'Desktop Computers', 2099.00, 9, 'Streamlined airflow chassis, Intel Core i7-14700F, liquid cooling, 32GB DDR5, 1TB SSD + 2TB HDD, and NVIDIA RTX 4070 Ti Super.', 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=800&q=80'),
(9, 'Microsoft Surface Laptop Studio 2', '2-in-1 Laptops', 2399.00, 11, 'Dynamic woven hinge transitioning from laptop to creative studio canvas, 14.4" PixelSense 120Hz touch, Core i7, 32GB RAM, RTX 4050.', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80'),
(10, 'MSI Creator P100X Studio PC', 'Workstations', 2899.00, 5, 'Designed for professional content creators and 3D rendering: Intel Core i9-13900K, 64GB DDR5, 2TB NVMe SSD, and NVIDIA RTX 4070 Ti.', 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80')
ON DUPLICATE KEY UPDATE 
    `name` = VALUES(`name`),
    `category` = VALUES(`category`),
    `price` = VALUES(`price`),
    `stock` = VALUES(`stock`),
    `description` = VALUES(`description`),
    `image` = VALUES(`image`);
