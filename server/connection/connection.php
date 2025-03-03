<?php
$hostname = 'localhost';
$username = "root";
$password = "";
$database = "paywallet_db";

$conn = mysqli_connect($host, $username, $password, $database);
if (mysqli_connect_error()) {
    die("Connection Failed: " . $conn->connect_error);
}
