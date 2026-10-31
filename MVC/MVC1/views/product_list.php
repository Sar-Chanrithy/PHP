<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog - MVC Example</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --accent-hover: #0ea5e9;
            --border: #334155;
            --price: #4ade80;
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
            max-width: 1040px;
        }
        .header {
            margin-bottom: 30px;
            text-align: center;
        }
        .badge {
            display: inline-block;
            background: rgba(56, 189, 248, 0.15);
            color: var(--accent);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
            border: 1px solid rgba(56, 189, 248, 0.3);
        }
        h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }
        p.subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 24px;
        }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
        }
        .card-img-wrapper {
            position: relative;
            width: 100%;
            height: 190px;
            background: #0b1120;
            overflow: hidden;
        }
        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
            display: block;
        }
        .card:hover .card-img {
            transform: scale(1.06);
        }
        .stock-tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--price);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }
        .card-body {
            padding: 16px 18px 10px;
            flex-grow: 1;
        }
        .card-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--accent);
            letter-spacing: 0.05em;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .card-title {
            font-size: 1.15rem;
            line-height: 1.35;
            margin-bottom: 8px;
            color: var(--text-main);
        }
        .card-footer {
            padding: 12px 18px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        .card-price {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--price);
        }
        .btn {
            display: inline-block;
            text-align: center;
            background: var(--accent);
            color: #0f172a;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: background 0.2s ease, transform 0.15s ease;
        }
        .btn:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }
        .mvc-note {
            margin-top: 40px;
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
        <div class="header">
            <span class="badge">VIEW LAYER: product_list.php</span>
            <h1>Computer &amp; Tech Catalog</h1>
            <p class="subtitle">This view receives data from <code>ProductController</code> and displays it.</p>
        </div>

        <div class="grid">
            <?php foreach ($products as $product): ?>
                <?php 
                    $defaultImage = 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80';
                    $imageUrl = !empty($product['image']) ? $product['image'] : $defaultImage;
                ?>
                <div class="card">
                    <div class="card-img-wrapper">
                        <img src="<?= htmlspecialchars($imageUrl) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="card-img" 
                             loading="lazy"
                             onerror="this.src='<?= $defaultImage ?>';">
                        <span class="stock-tag"><?= (int)$product['stock'] ?> in stock</span>
                    </div>

                    <div class="card-body">
                        <div class="card-category"><?= htmlspecialchars($product['category']) ?></div>
                        <h2 class="card-title"><?= htmlspecialchars($product['name']) ?></h2>
                    </div>

                    <div class="card-footer">
                        <div class="card-price">$<?= number_format($product['price'], 2) ?></div>
                        <a href="index.php?action=detail&id=<?= $product['id'] ?>" class="btn">View Details</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mvc-note">
            💡 <strong>How MVC works here:</strong> The Controller queried the Model (<code>$model->getAllProducts()</code>), received the product array with pictures from the MySQL database, and passed it to this View as <code>$products</code>. This file contains only HTML presentation and loop rendering — no database queries or business logic!
        </div>
    </div>
</body>
</html>
