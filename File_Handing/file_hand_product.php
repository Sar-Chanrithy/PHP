<?php
$name = '';
$age = '';
$grade = '';
$course = '';
$profile = '';
if (isset($_POST['btnsubmit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];
    $course = $_POST['course'];


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
        height: 600px;
        display: flex;
        justify-content: center;
    }
</style>

<body>
    <div class="p">
        <div class="l">
            <form method="post" enctype="multipart/form-data" class="shadow-lg h-100 p-3 mt-5 rounded-3"
                style="width: 40%;">
                <h1 class="text-center">Product Student</h1>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">grade</label>
                    <input type="text" name="grade" class="form-control" id="exampleInputPassword1">
                </div><div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">course</label>
                    <input type="text" name="course" class="form-control" id="exampleInputPassword1">
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

        <div class="container mt-5 "> >
            <table class="table container mt-5 shadow-lg p-3 mb-5 bg-body rounded  ">
            <thead>
                <tr>
                    <th scope="col">Name Studnet</th>
                    <th scope="col">Age</th>
                    <th scope="col">Grade</th>
                    <th scope="col">Course</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '
                    <tr>
                        <td>' . $name . '</td>
                        <td>' . $age . '</td>
                        <td>' . $grade . '</td>
                        <td>' . $course . '</td>
                        <td><img src="./upload/' . $profile . '" width="200px" alt=""></td>
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
    </div>
</body>

</html>