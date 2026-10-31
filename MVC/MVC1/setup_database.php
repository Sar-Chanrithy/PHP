<?php
/**
 * Database Setup Script
 * Run this file once in your browser (or via CLI) to automatically create
 * the database, table, and seed initial records.
 */

$host     = 'localhost';
$username = 'root';
$password = '';
$database = 'mvc_db';
$charset  = 'utf8mb4';

$messages = [];
$success  = false;

try {
    // 1. Connect to MySQL server (without selecting database first)
    $dsn = "mysql:host=$host;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $messages[] = ["type" => "success", "text" => "Connected to MySQL server successfully."];

    // 2. Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    $messages[] = ["type" => "success", "text" => "Database `<strong>$database</strong>` created or already exists."];

    // 3. Select the database
    $pdo->exec("USE `$database`;");

    // 4. Create products table (with image column)
    $sqlCreateTable = "
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
    ";
    $pdo->exec($sqlCreateTable);

    // Ensure image column exists if table was created previously without it
    try {
        $pdo->exec("ALTER TABLE `products` ADD COLUMN `image` VARCHAR(500) NULL AFTER `description`");
    } catch (PDOException $e) {
        // Column already exists, safe to ignore
    }

    $messages[] = ["type" => "success", "text" => "Table `<strong>products</strong>` (with picture support) verified / created."];

    // 5. Seed 10 computer products with pictures
    $sampleProducts = [
        [
            'id' => 1,
            'name' => 'Apple MacBook Pro 16" (M3 Max)',
            'category' => 'Laptops',
            'price' => 3499.00,
            'stock' => 10,
            'description' => 'Apple M3 Max chip with 16-core CPU, 40-core GPU, 48GB unified memory, 1TB SSD, and 16.2-inch Liquid Retina XDR display.',
            'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 2,
            'name' => 'Dell XPS 15 (9530)',
            'category' => 'Laptops',
            'price' => 1899.00,
            'stock' => 15,
            'description' => '15.6-inch 3.5K OLED touchscreen, Intel Core i7-13700H, 32GB DDR5 RAM, 1TB NVMe SSD, and NVIDIA GeForce RTX 4060 graphics.',
            'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 3,
            'name' => 'ASUS ROG Zephyrus G16',
            'category' => 'Gaming Laptops',
            'price' => 2199.00,
            'stock' => 12,
            'description' => '16-inch 2.5K 240Hz OLED ROG Nebula display, Intel Core Ultra 9 185H, 32GB LPDDR5X, 1TB SSD, and NVIDIA GeForce RTX 4080.',
            'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 4,
            'name' => 'Lenovo ThinkPad X1 Carbon Gen 12',
            'category' => 'Business Laptops',
            'price' => 1599.00,
            'stock' => 20,
            'description' => 'Ultralight carbon-fiber chassis, Intel Core Ultra 7 155H, 16GB RAM, 512GB SSD, legendary ThinkPad keyboard, and all-day battery.',
            'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 5,
            'name' => 'HP OMEN 45L Gaming Desktop',
            'category' => 'Desktop Computers',
            'price' => 2499.00,
            'stock' => 8,
            'description' => 'Extreme gaming desktop with patented Cryo Chamber cooling, Intel Core i9-14900K, 64GB DDR5, 2TB SSD, and NVIDIA RTX 4080 Super.',
            'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 6,
            'name' => 'Apple iMac 24" 4.5K (M3)',
            'category' => 'All-in-One PC',
            'price' => 1399.00,
            'stock' => 14,
            'description' => 'Vibrant ultra-thin all-in-one desktop featuring 4.5K Retina display, Apple M3 8-core CPU, 8-core GPU, 16GB RAM, and 512GB SSD.',
            'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 7,
            'name' => 'Acer Predator Helios 18',
            'category' => 'Gaming Laptops',
            'price' => 2299.00,
            'stock' => 7,
            'description' => '18-inch Mini LED 250Hz display, Intel Core i9-14900HX, 32GB DDR5, 1TB PCIe Gen4 SSD, and NVIDIA GeForce RTX 4080 12GB.',
            'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 8,
            'name' => 'Alienware Aurora R16 Gaming PC',
            'category' => 'Desktop Computers',
            'price' => 2099.00,
            'stock' => 9,
            'description' => 'Streamlined airflow chassis, Intel Core i7-14700F, liquid cooling, 32GB DDR5, 1TB SSD + 2TB HDD, and NVIDIA RTX 4070 Ti Super.',
            'image' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 9,
            'name' => 'Microsoft Surface Laptop Studio 2',
            'category' => '2-in-1 Laptops',
            'price' => 2399.00,
            'stock' => 11,
            'description' => 'Dynamic woven hinge transitioning from laptop to creative studio canvas, 14.4" PixelSense 120Hz touch, Core i7, 32GB RAM, RTX 4050.',
            'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'id' => 10,
            'name' => 'MSI Creator P100X Studio PC',
            'category' => 'Workstations',
            'price' => 2899.00,
            'stock' => 5,
            'description' => 'Designed for professional content creators and 3D rendering: Intel Core i9-13900K, 64GB DDR5, 2TB NVMe SSD, and NVIDIA RTX 4070 Ti.',
            'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80'
        ]
    ];

    $insertStmt = $pdo->prepare("
        INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock`, `description`, `image`)
        VALUES (:id, :name, :category, :price, :stock, :description, :image)
        ON DUPLICATE KEY UPDATE
            `name` = VALUES(`name`),
            `category` = VALUES(`category`),
            `price` = VALUES(`price`),
            `stock` = VALUES(`stock`),
            `description` = VALUES(`description`),
            `image` = VALUES(`image`)
    ");

    foreach ($sampleProducts as $p) {
        $insertStmt->execute($p);
    }
    $messages[] = ["type" => "success", "text" => "Successfully seeded " . count($sampleProducts) . " initial products with pictures into the database."];

    // Fetch count to display
    $count = $pdo->query("SELECT COUNT(*) FROM `products`")->fetchColumn();
    $messages[] = ["type" => "info", "text" => "Total products now in database: <strong>$count</strong>."];

    $success = true;
} catch (PDOException $e) {
    $messages[] = ["type" => "error", "text" => "Database Error: " . htmlspecialchars($e->getMessage())];
    $success = false;
}

// If run via CLI, output text and exit
if (php_sapi_name() === 'cli') {
    echo "==========================================\n";
    echo "       DATABASE INITIALIZATION SETUP      \n";
    echo "==========================================\n";
    foreach ($messages as $msg) {
        echo "[" . strtoupper($msg['type']) . "] " . strip_tags($msg['text']) . "\n";
    }
    exit($success ? 0 : 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - MVC Application</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --accent-hover: #0ea5e9;
            --success: #4ade80;
            --error: #f87171;
            --border: #334155;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .setup-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            padding: 32px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .header {
            margin-bottom: 24px;
            text-align: center;
        }
        .icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }
        h1 {
            font-size: 1.75rem;
            margin-bottom: 8px;
        }
        p.subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .log-box {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .log-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }
        .log-item.success { color: var(--success); }
        .log-item.info { color: var(--accent); }
        .log-item.error { color: var(--error); }
        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .btn {
            display: inline-block;
            text-align: center;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: var(--accent);
            color: #0f172a;
        }
        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover {
            color: var(--text-main);
            border-color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="setup-card">
        <div class="header">
            <div class="icon"><?= $success ? '🚀' : '⚠️' ?></div>
            <h1><?= $success ? 'Database Ready!' : 'Setup Failed' ?></h1>
            <p class="subtitle">MySQL Database Setup for MVC Product System</p>
        </div>

        <div class="log-box">
            <?php foreach ($messages as $msg): ?>
                <div class="log-item <?= $msg['type'] ?>">
                    <span><?= $msg['type'] === 'success' ? '✔' : ($msg['type'] === 'error' ? '✖' : 'ℹ') ?></span>
                    <div><?= $msg['text'] ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="actions">
            <?php if ($success): ?>
                <a href="index.php" class="btn btn-primary">Go to Product Catalog &rarr;</a>
            <?php else: ?>
                <a href="setup_database.php" class="btn btn-primary">Try Again</a>
            <?php endif; ?>
            <a href="database.sql" download class="btn btn-secondary">Download database.sql</a>
        </div>
    </div>
</body>
</html>
