<?php
require("../../connection/connection.php");
require("../../models/user.php");
require("../../models/wallet.php");

if (!isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['password'])) {
    http_response_code(400);

    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit();
}

$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$result = User::create($email, $phone, $password);
return json_encode($result);
