
CREATE DATABASE IF NOT EXISTS student_db;
USE student_db;


CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    dob DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    major VARCHAR(100) NOT NULL
);


INSERT INTO students (name, gender, dob, email, phone, major) VALUES
('Sokha Chan', 'Female', '2004-03-15', 'sokha.chan@example.com', '+855 12 345 678', 'Computer Science'),
('David Kim', 'Male', '2003-08-22', 'david.kim@example.com', '+855 15 987 654', 'Information Technology'),
('Emily Watson', 'Female', '2004-11-05', 'emily.watson@example.com', '+855 70 112 233', 'Software Engineering'),
('Visal Meng', 'Male', '2003-01-30', 'visal.meng@example.com', '+855 88 445 566', 'Data Science'),
('Sarah Jenkins', 'Female', '2005-06-18', 'sarah.j@example.com', '+855 92 778 899', 'Cybersecurity');