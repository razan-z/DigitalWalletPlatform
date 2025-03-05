<?php
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json;charset=UTF-8");

$hostname = 'localhost';
$username = "root";
$password = "";
$database = "paywallet_db";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_error()) {
    echo json_encode([
        "message" => "Database connection failed"
    ]);
    exit();
}
