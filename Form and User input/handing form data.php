<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "student_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];

    if (empty($name)) {
        $message = "Name is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {

        $sql = "INSERT INTO users(name, email)
                VALUES('$name', '$email')";

        if (mysqli_query($conn, $sql)) {
            $message = "Form submitted successfully!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Form</title>
</head>
<body>

<h2>Student Form</h2>

<form method="POST">

    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <input type="submit" value="Submit">

</form>

<br>

<?php
echo $message;
?>

</body>
</html>