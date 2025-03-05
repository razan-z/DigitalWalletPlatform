<?php
include("../../connection/connection.php");

if (!isset($_POST['password']) || (!isset($_POST['email']) || !isset($_POST['phone']))) {
    http_response_code(400);

    echo json_encode([
        "message" => "Missing required fields"
    ]);
    exit();
}

$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];



$query = "SELECT * FROM users WHERE email = ? AND phone = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $email, $phone);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

try {
    if (password_verify($password, $user["password"])) {
        $new_token = bin2hex(random_bytes(32));

        $update_stmt = $conn->prepare("UPDATE users SET token=? WHERE id=?");
        $update_stmt->bind_param("si", $new_token, $user['id']);
        $update_stmt->execute();

        echo json_encode([
            "message" => "success",
            "token" => $new_token
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            "message" => "Invalid credentials"
        ]);
    }
} catch (\Throwable $e) {
    http_response_code(400);

    echo json_encode([
        "message" => $e
    ]);
}
