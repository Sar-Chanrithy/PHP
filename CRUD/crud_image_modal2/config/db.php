<?php
    try {
        $con = new mysqli('localhost', 'root', '1234', 'db_crudimagesub');
        echo "success";
    } catch (\Throwable $th) {
        echo "error" .$th;
    }
?>