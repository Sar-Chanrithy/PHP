<?php
if (isset($_POST['submit'])) {

    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $total = $qty * $price;


    echo "<h3>Product Information</h3>";
    echo "<p><strong>Product:</strong> $product</p>";
    echo "<p><strong>Quantity:</strong> $qty</p>";
    echo "<p><strong>Price:</strong> $$price</p>";
    echo "<p><strong>Description:</strong> $description</p>";
    echo "<p><strong>Total:</strong> $$total</p>";

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" method="post" id="exampleModal" tabindex="" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="qty" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">
                                Submit
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>