<?php
require("../../connection/connection.php");

// Get token from Authorization header
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

if (!$token) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$stmt = $conn->prepare("SELECT id, email, verification_status FROM users WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Invalid token"]);
    exit();
}

$user = $result->fetch_assoc();

$stmt = $conn->prepare("SELECT currency, balance FROM wallets WHERE user_id = ?");
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();

$wallets = [];
while ($row = $result->fetch_assoc()) {
    $wallets[] = [
        "currency" => $row["currency"],
        "balance" => $row["balance"]
    ];
}
echo json_encode([
    "status" => "success",
    "user" => [
        "email" => $user["email"],
        "verified" => $user["verification_status"],
        "wallets" => $wallets
    ]
]);
