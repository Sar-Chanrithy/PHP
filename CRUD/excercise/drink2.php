<?php
include "./Connection1.php";
?>

<?php
if (isset($_POST['btnSave'])) {
    $name = $_POST['name'];
    $des = $_POST['des'];

    global $con;
    $query = "INSERT INTO tb_drink ( name, description) VALUES ('$name', '$des')";
    $data = $con->query($query);
    if ($data) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['btnUpdate'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['edit_name'];
    $des = $_POST['edit_des'];

    global $con;
    $query = "UPDATE tb_drink SET name = '$name', description = '$des' WHERE id = '$id'";
    $data = $con->query($query);
    if ($data) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM tb_drink WHERE id = '$id'";
    $p = $con->query($query);

    if ($p) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Delete failed: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Description</label>
                        <input type="text" name="des" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btnSave" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <button type="button" class="btn btn-primary float-end mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add new Student
    </button>

    <center>
        <table class="table w-75 mt-5">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    global $con;
                    $query = "SELECT * FROM tb_drink";
                    $data = $con->query($query);
                    while($row = $data->fetch_assoc()){
                        echo '
                        <tr>
                            <th scope="row">'.$row['id'].'</th>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['description'].'</td>
                            <td><a href="?delete='.$row['id'].'" class="btn btn-danger">Delete</a></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal'.$row['id'].'">
                                    Update
                                </button>

                                <div class="modal fade" id="updateModal'.$row['id'].'" tabindex="-1" aria-labelledby="updateModalLabel'.$row['id'].'" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="updateModalLabel'.$row['id'].'">Update Drink</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <input type="hidden" name="edit_id" value="'.$row['id'].'">
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" name="edit_name" value="'.$row['name'].'" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3 text-start">
                                                        <label class="form-label">Description</label>
                                                        <input type="text" name="edit_des" value="'.$row['description'].'" class="form-control" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="btnUpdate" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </center>
</div>

</body>
</html>