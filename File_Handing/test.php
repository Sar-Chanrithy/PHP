<?php
$username = "";
$email = "";
$password = "";
$profiles = "";
if (isset($_POST['btnsubmit'])) {
    $username = htmlspecialchars($_POST['username']);
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];
    } else {
        echo "<script>alert('invalid email')</script>";
    }
    $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_BCRYPT));

    $profiles = $_FILES['profile']['name'];

    $temp_name = $_FILES['profile']['tmp_name'];
    $path = "./upload/" . $profiles;
    move_uploaded_file($temp_name, $path);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxIlFvY47316cr9Zw887vP4J8+LH7qKQNugkuIAvNLzeNBt5YBuJzQjLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FkyoEForCGlyvwx9Hj09jCYm3nv71PVlz7YYwJrWVcXK/BmnVDxM+D2scQBITxI" crossorigin="anonymous"></script>
    <style>
        .p {
        }
        .1 {
            width: 100%;
            height: 500px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="p">
        <div class="container 1">
            <form method="post" enctype="multipart/form-data" class="shadow-lg h-100 p-3 mt-5 rounded-3" style="width: 40%;">
                <h1 class="text-center">Register</h1>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Image</label>
                    <input type="file" class="form-control" name="profile" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" name="btnsubmit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>

        <table class="table container mt-5">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '
                <tr>
                    <td>'.$username.'</td>
                    <td>'.$email.'</td>
                    <td>'.$password.'</td>
                    <td><img src="./upload/'.$profiles.'" width="200px" alt=""></td>
                    <td>
                        <button class="btn btn-danger">Delete</button>
                        <button class="btn btn-warning">Update</button>
                    </td>
                </tr>
                ';
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>