<?php

try {
    //create PDO connection
    $conn = new PDO("mysql:host=localhost;dbname=db_app_gaji", "root", "");
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}
