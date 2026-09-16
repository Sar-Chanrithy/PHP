<?php

$conn = new mysqli("127.0.0.1", "root", "1234", "db_php11");

if ($conn->connect_errno) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");