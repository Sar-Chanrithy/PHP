<?php
$products = [
    [
        "id" => 1,
        "name" => "Coca",
        "qty" => 10,
        "price" => 1.50,
    ],
    [
        "id" => 2,
        "name" => "Sting",
        "qty" => 20,
        "price" => 1.50,
    ],
    [
        "id" => 3,
        "name" => "Pepsi",
        "qty" => 15,
        "price" => 1.25,
    ],
    [
        "id" => 4,
        "name" => "Provida",
        "qty" => 20,
        "price" => 2.00,
    ]
];

$grandTotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            // Loop through the array to generate table rows
            foreach ($products as $product) {
                $total = $product["qty"] * $product["price"];
                $grandTotal += $total; // Add to grand total

  
                $formattedPrice = number_format($product["price"], 2);
                $formattedTotal = number_format($total, 2);

                echo "<tr>
                    <th scope='row'>{$product['id']}</th>
                    <td>{$product['name']}</td>
                    <td>{$product['qty']}</td>
                    <td>\${$formattedPrice}</td>
                    <td>\${$formattedTotal}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>