<?php
    //1.connect to mysql database
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "userDB";
    $conn = mysqli_connect($host, $user, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
