<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "acr_mart"; // your database name

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
