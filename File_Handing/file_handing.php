<?php
$username = '';
$email = '';
$password = '';
$profile = '';
if (isset($_POST['btnsubmit'])) {
    $username = htmlspecialchars($_POST['username']);
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];
    } else {
        echo "<script>alert('invalid email')</script>";
    }
    $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_BCRYPT));




      $profile  = $_FILES['profile']['name'];
    $temp_name= $_FILES['profile']['tmp_name'];
    echo $temp_name;
    $path = "./upload/".$profile;
    move_uploaded_file($temp_name,$path);
}
 
         

    

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</head>
<style>
    .p {}

    .l {
        width: 100%;
        height: 500px;
        display: flex;
        justify-content: center;
    }
</style>

<body>
    <div class="p">
        <div class="l">
            <form method="post" enctype = "multipart/form-data"  class="shadow-lg h-100 p-3 mt-5 rounded-3" style="width: 40%;">
                <h1 class="text-center">Register</h1>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
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
        </div>

        <table class="table container mt-5">
            <thead>
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
                        <td>' . $username . '</td>
                        <td>' . $email . '</td>
                        <td>' . $password . '</td>
                        <td><img src="./upload/'.$profile.'" width="200px" alt=""></td>
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

