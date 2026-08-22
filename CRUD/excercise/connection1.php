<?php

try {
    $con = new mysqli("localhost","root","1234","etec_crudstu");
    // echo "success";
} catch (\Throwable $e) {
    echo "fail connection".$e;
}