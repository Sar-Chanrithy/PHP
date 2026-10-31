<?php
/**
 * Script to insert 10 Computer products with pictures into the database.
 * Run in browser: http://localhost/BACK-END_ETEC/code/MVC/MVC1/insert_computers.php
 */
require_once __DIR__ . '/config/Database.php';

try {
    $db = Database::getConnection();

    // 1. Ensure `image` column exists in `products` table
    try {
        $db->exec("ALTER TABLE `products` ADD COLUMN `image` VARCHAR(500) NULL AFTER `description`");
    } catch (PDOException $e) {
        // Column already exists, safe to continue
    }

    // 2. Define 10 computers with high-quality pictures
    $computers = [
        [
            'name'        => 'Apple MacBook Pro 16" (M3 Max)',
            'category'    => 'Laptops',
            'price'       => 3499.00,
            'stock'       => 10,
            'description' => 'Apple M3 Max chip with 16-core CPU, 40-core GPU, 48GB unified memory, 1TB SSD, and 16.2-inch Liquid Retina XDR display.',
            'image'       => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Dell XPS 15 (9530)',
            'category'    => 'Laptops',
            'price'       => 1899.00,
            'stock'       => 15,
            'description' => '15.6-inch 3.5K OLED touchscreen, Intel Core i7-13700H, 32GB DDR5 RAM, 1TB NVMe SSD, and NVIDIA GeForce RTX 4060 graphics.',
            'image'       => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'ASUS ROG Zephyrus G16',
            'category'    => 'Gaming Laptops',
            'price'       => 2199.00,
            'stock'       => 12,
            'description' => '16-inch 2.5K 240Hz OLED ROG Nebula display, Intel Core Ultra 9 185H, 32GB LPDDR5X, 1TB SSD, and NVIDIA GeForce RTX 4080.',
            'image'       => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Lenovo ThinkPad X1 Carbon Gen 12',
            'category'    => 'Business Laptops',
            'price'       => 1599.00,
            'stock'       => 20,
            'description' => 'Ultralight carbon-fiber chassis, Intel Core Ultra 7 155H, 16GB RAM, 512GB SSD, legendary ThinkPad keyboard, and all-day battery.',
            'image'       => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'HP OMEN 45L Gaming Desktop',
            'category'    => 'Desktop Computers',
            'price'       => 2499.00,
            'stock'       => 8,
            'description' => 'Extreme gaming desktop with patented Cryo Chamber cooling, Intel Core i9-14900K, 64GB DDR5, 2TB SSD, and NVIDIA RTX 4080 Super.',
            'image'       => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Apple iMac 24" 4.5K (M3)',
            'category'    => 'All-in-One PC',
            'price'       => 1399.00,
            'stock'       => 14,
            'description' => 'Vibrant ultra-thin all-in-one desktop featuring 4.5K Retina display, Apple M3 8-core CPU, 8-core GPU, 16GB RAM, and 512GB SSD.',
            'image'       => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Acer Predator Helios 18',
            'category'    => 'Gaming Laptops',
            'price'       => 2299.00,
            'stock'       => 7,
            'description' => '18-inch Mini LED 250Hz display, Intel Core i9-14900HX, 32GB DDR5, 1TB PCIe Gen4 SSD, and NVIDIA GeForce RTX 4080 12GB.',
            'image'       => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Alienware Aurora R16 Gaming PC',
            'category'    => 'Desktop Computers',
            'price'       => 2099.00,
            'stock'       => 9,
            'description' => 'Streamlined airflow chassis, Intel Core i7-14700F, liquid cooling, 32GB DDR5, 1TB SSD + 2TB HDD, and NVIDIA RTX 4070 Ti Super.',
            'image'       => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'Microsoft Surface Laptop Studio 2',
            'category'    => '2-in-1 Laptops',
            'price'       => 2399.00,
            'stock'       => 11,
            'description' => 'Dynamic woven hinge transitioning from laptop to creative studio canvas, 14.4" PixelSense 120Hz touch, Core i7, 32GB RAM, RTX 4050.',
            'image'       => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=800&q=80'
        ],
        [
            'name'        => 'MSI Creator P100X Studio PC',
            'category'    => 'Workstations',
            'price'       => 2899.00,
            'stock'       => 5,
            'description' => 'Designed for professional content creators and 3D rendering: Intel Core i9-13900K, 64GB DDR5, 2TB NVMe SSD, and NVIDIA RTX 4070 Ti.',
            'image'       => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80'
        ]
    ];

    $stmt = $db->prepare("
        INSERT INTO `products` (`name`, `category`, `price`, `stock`, `description`, `image`) 
        VALUES (:name, :category, :price, :stock, :description, :image)
    ");

    $insertedCount = 0;
    foreach ($computers as $computer) {
        $stmt->execute($computer);
        $insertedCount++;
    }

    $totalCount = $db->query("SELECT COUNT(*) FROM `products`")->fetchColumn();
    $success = true;
} catch (Exception $e) {
    $error = $e->getMessage();
    $success = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Computers with Pictures</title>
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            padding: 32px;
            max-width: 540px;
            width: 100%;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }
        h1 {
            color: <?= $success ? '#4ade80' : '#f87171' ?>;
            margin-bottom: 12px;
            font-size: 1.6rem;
        }
        p {
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .btn {
            display: inline-block;
            background: #38bdf8;
            color: #0f172a;
            font-weight: 600;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .btn:hover {
            background: #0ea5e9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1><?= $success ? '✔ Computers with Pictures Inserted!' : '✖ Insertion Failed' ?></h1>
        <?php if ($success): ?>
            <p>Successfully added <strong><?= $insertedCount ?></strong> computer models with pictures into your database.<br>Total products in catalog: <strong><?= $totalCount ?></strong>.</p>
            <a href="index.php" class="btn">View in Product Catalog &rarr;</a>
        <?php else: ?>
            <p style="color: #f87171;"><?= htmlspecialchars($error) ?></p>
            <a href="setup_database.php" class="btn">Setup Database First</a>
        <?php endif; ?>
    </div>
</body>
</html>
