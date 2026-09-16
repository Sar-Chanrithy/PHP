-- Course CRUD Database Schema
-- Database: `course_db`

CREATE DATABASE IF NOT EXISTS `course_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `course_db`;

-- Table structure for table `courses`
CREATE TABLE IF NOT EXISTS `courses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Data (Optional)
-- INSERT INTO `courses` (`name`, `price`, `image`) VALUES
-- ('Modern Web Development', 49.99, 'sample1.jpg'),
-- ('PHP & MySQL Mastery', 39.50, 'sample2.jpg');
