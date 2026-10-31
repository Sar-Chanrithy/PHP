<main>
    <form action="<?= BASE_URL ?>/update" method="POST" enctype="multipart/form-data">
        <h1>Update Product</h1>

        <input type="hidden" name="id" value="<?= $product['id'] ?? '' ?>">

        <input type="text" name="title" value="<?= htmlspecialchars($product['title'] ?? '') ?>" placeholder="title" required><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?? 0 ?>" placeholder="price" required><br>
        <input type="number" name="stock" value="<?= $product['stock'] ?? 0 ?>" placeholder="stock" required><br>

        <input type="file" name="image" onchange="previewImage(this)"><br>

        <?php 
            $imgName = basename($product['image'] ?? '');
            $imgSrc = '';
            if (!empty($product['image'])) {
                $imgSrc = str_starts_with($product['image'], 'http') 
                    ? $product['image'] 
                    : BASE_URL . '/asset/uploads/' . $imgName;
            }
        ?>
        <?php if (!empty($imgSrc)): ?>
            <img src="<?= htmlspecialchars($imgSrc) ?>" width="100px" id="preview"><br>
        <?php else: ?>
            <img src="" width="100px" id="preview" style="display:none;"><br>
        <?php endif; ?>

        <input type="text" name="description" value="<?= htmlspecialchars($product['description'] ?? '') ?>" placeholder="description"><br>

        <button type="submit">Update</button>
        <button type="reset" onclick="resetPreview()">Reset</button>
    </form>

    <a href="<?= BASE_URL ?>/">Back</a>
</main>

<script>
    const preview = document.getElementById('preview');
    const originalSrc = preview ? preview.src : '';

    function previewImage(input) {
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        }
    }

    function resetPreview() {
        if (preview) {
            preview.src = originalSrc;
            if (!originalSrc) {
                preview.style.display = 'none';
            }
        }
    }
</script>

</script>