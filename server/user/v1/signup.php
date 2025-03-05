<?php
require("../../connection/connection.php");

if (!isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['password'])) {
    http_response_code(400);

    echo json_encode([
        "message" => "Missing required fields"
    ]);
    exit();
}

$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = ? AND phone = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "This credentials have already been used"
    ]);
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    //generate token
    $token = bin2hex(random_bytes(32));
    $query = "INSERT INTO users (email, phone, password, token) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $email, $phone, $hashed_password, $token);
    $stmt->execute();
    echo json_encode([
        "status" => "success",
        "token" => $token,
    ]);
}
