<main>
    <form action="<?= BASE_URL ?>/store" method="POST" enctype="multipart/form-data">
        <h1>Create Product</h1>
        <input type="text" name="title" placeholder="title" required> <br>
        <input type="number" step="0.01" name="price" placeholder="price" required> <br>
        <input type="number" name="stock" placeholder="stock" required> <br>
        <input type="file" name="image" placeholder="image"> <br>
        <input type="text" name="description" placeholder="description"> <br>
        <button type="submit">Create</button> <br>
        <button type="reset">Reset</button>
    </form>
    <a href="<?= BASE_URL ?>/">Back</a>
</main>
