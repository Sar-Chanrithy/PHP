<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>

<body>
    <h1>Product List</h1>
    <a href="<?= BASE_URL ?>/create">create</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>price</th>
                <th>stock</th>
                <th>image</th>
                <th>description</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?? '' ?></td>
                        <td><?= htmlspecialchars($product['title'] ?? '') ?></td>
                        <td>$<?= number_format((float)($product['price'] ?? 0), 2) ?></td>
                        <td><?= $product['stock'] ?? 0 ?></td>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <?php 
                                    $imgName = basename($product['image']);
                                    $imgSrc = str_starts_with($product['image'], 'http') 
                                        ? $product['image'] 
                                        : BASE_URL . '/asset/uploads/' . $imgName;
                                ?>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" width="100px">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['description'] ?? '') ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/edit?id=<?= $product['id'] ?? '' ?>">edit</a> <br>
                            <form action="<?= BASE_URL ?>/delete?id=<?= $product['id'] ?? '' ?>" method="POST"
                                onsubmit="return confirm('Delete this product?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $product['id'] ?? '' ?>">
                                <button type="submit">delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>
