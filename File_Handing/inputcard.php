<?php
$name = "";
$brand = "";
$model = "";
$price = "";
$cost = "";
$year = "";
$profile = "";
if (isset($_POST['btnsubmit'])) {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $year = $_POST['year'];


    $profile = $_FILES['profile']['name'];
    $temp_name = $_FILES['profile']['tmp_name'];
    echo $temp_name;
    $path = "./upload/" . $profile;
    move_uploaded_file($temp_name, $path);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CJMcapSmO7SnpJef0486qhLnaZ2cle9d2Lw689A4V" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWtLSNXJ9mgli8mvw4BNC4rE9Dtrad1JIign/j3S5DLy3fe4bKZ"
        crossorigin="anonymous"></script>
</head>

<body>
    <style>
        .p {}

        .c {

            margin-left: 50px;
            margin-top: 50px;
        }

        .l {
            width: 100%;
            height: 800px;
            display: flex;
            justify-content: left;
            margin-left: 20px;
        }
    </style>

    <body>
        <div class="p">
            <div class="l">
                <form method="post" enctype="multipart/form-data" class="shadow-lg h-100 p-3 mt-5 rounded-3"
                    style="width: 40%;">
                    <h1 class="text-center">Add New Product</h1>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Cost</label>
                        <input type="text" name="cost" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Year</label>
                        <input type="text" name="year" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Image</label>
                        <input type="file" name="profile" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" name="btnsubmit" class="btn btn-primary">Submit</button>
                </form>

                <div class="c">
                    <div class="card" style="width: 18rem;">
                        <img src="./upload/<?php echo $profile; ?>" class="card-img-top" alt="">
                        <div class="card-body">
                            <?php
                            echo '
                            <h5 class="card-title">'. $name .'</h5>
                            <p class="card-text">'. $brand .' / '. $model .'</p>
                            <p class="card-text">Price: $'. $price .'</p>
                            <p class="card-text">Cost: $'. $cost .'</p>
                            <p class="card-text">Year: '. $year .'</p>
                            <a href="#" class="btn btn-primary">Buy Now</a>
                            ';
                            ?>
                            <button class="btn btn-danger">Delete</button>
                            <button class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </body>

</html>