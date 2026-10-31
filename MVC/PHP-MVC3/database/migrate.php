<?php

require_once __DIR__ . "/../app/Core/Database.php";

echo "--- Starting Database Migration ---\n";

try {
    $pdo = Database::connection();
    echo "✓ Database and tables are ready!\n";
} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
}
