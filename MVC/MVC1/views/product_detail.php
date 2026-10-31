<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['name']) : 'Product Not Found' ?> - MVC Example</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --border: #334155;
            --price: #4ade80;
            --error: #f87171;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 680px;
        }
        .badge {
            display: inline-block;
            background: rgba(56, 189, 248, 0.15);
            color: var(--accent);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }
        .detail-img-box {
            width: 100%;
            height: 320px;
            background: #0b1120;
            overflow: hidden;
            position: relative;
        }
        .detail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .detail-content {
            padding: 28px 30px;
        }
        .category {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 0.05em;
        }
        h1 {
            font-size: 1.85rem;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .meta-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .price {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--price);
        }
        .stock-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(74, 222, 128, 0.15);
            color: var(--price);
            border: 1px solid rgba(74, 222, 128, 0.25);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .description-title {
            font-size: 0.95rem;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 600;
        }
        .description {
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 30px;
            font-size: 1rem;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 18px;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .back-link:hover {
            background: rgba(56, 189, 248, 0.2);
            transform: translateX(-3px);
        }
        .mvc-note {
            margin-top: 30px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px dashed var(--border);
            border-radius: 8px;
            padding: 15px 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.6;
        }
        .mvc-note strong {
            color: var(--accent);
        }
    </style>
</head>
<body>
    <div class="container">
        <span class="badge">VIEW LAYER: product_detail.php</span>

        <div class="card">
            <?php if ($product): ?>
                <?php 
                    $defaultImage = 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80';
                    $imageUrl = !empty($product['image']) ? $product['image'] : $defaultImage;
                ?>
                <div class="detail-img-box">
                    <img src="<?= htmlspecialchars($imageUrl) ?>" 
                         alt="<?= htmlspecialchars($product['name']) ?>" 
                         class="detail-img"
                         onerror="this.src='<?= $defaultImage ?>';">
                </div>

                <div class="detail-content">
                    <div class="category"><?= htmlspecialchars($product['category']) ?></div>
                    <h1><?= htmlspecialchars($product['name']) ?></h1>
                    
                    <div class="meta-row">
                        <div class="price">$<?= number_format($product['price'], 2) ?></div>
                        <div class="stock-badge">In Stock: <?= (int)$product['stock'] ?> units</div>
                    </div>

                    <div class="description-title">Product Description</div>
                    <p class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                    <a href="index.php" class="back-link">&larr; Back to Products</a>
                </div>
            <?php else: ?>
                <div class="detail-content">
                    <h1 style="color: var(--error);">Product Not Found</h1>
                    <p class="description">The product you requested does not exist or has been removed.</p>
                    <a href="index.php" class="back-link">&larr; Back to Products</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="mvc-note">
            💡 <strong>MVC Flow:</strong> The Controller checked the URL query (<code>id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?></code>), fetched this specific product from <code>ProductModel::getProductById()</code> with its image, and loaded this View file.
        </div>
    </div>
</body>
</html>
