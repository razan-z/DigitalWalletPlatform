<?php
require("../../connection/connection.php");
require("../../models/user.php");

// Get token from Authorization header
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

if (!$token) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}


$stmt = $conn->prepare("SELECT id, verification_status FROM users WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Invalid token"]);
    exit();
}


$user = $result->fetch_assoc();

// Check if the user is verified
if ($user['verification_status'] === 'unverified') {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "You must verify your account to transfer money"]);
    exit();
}

// Get the request data
$data = json_decode(file_get_contents('php://input'), true);


if (empty($data['recipient']) || empty($data['amount']) || empty($data['currency']) || empty($data['transfer_type'])) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit();
}

$recipient = $data['recipient'];
$amount = (float) $data['amount'];
$currency = $data['currency'];
$transferType = $data['transfer_type'];
$fee = ($transferType === 'instant') ? 1.00 : 0.00;
$totalAmount = $amount + $fee;


$stmt = $conn->prepare("SELECT balance FROM wallets WHERE user_id = ? AND currency = ?");
$stmt->bind_param("is", $user['id'], $currency);
$stmt->execute();
$result = $stmt->get_result();
$senderWallet = $result->fetch_assoc();

if (!$senderWallet || $senderWallet['balance'] < $totalAmount) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Insufficient balance"]);
    exit();
}


$stmt = $conn->prepare("SELECT id, balance FROM users 
                        JOIN wallets ON users.id = wallets.user_id 
                        WHERE (email = ? OR phone = ?) AND currency = ?");
$stmt->bind_param("sss", $recipient, $recipient, $currency);
$stmt->execute();
$result = $stmt->get_result();
$recipientWallet = $result->fetch_assoc();

if (!$recipientWallet) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Recipient not found"]);
    exit();
}

// deduce from the balance of the sender
$newSenderBalance = $senderWallet['balance'] - $totalAmount;
$stmt = $conn->prepare("UPDATE wallets SET balance = ? WHERE user_id = ? AND currency = ?");
$stmt->bind_param("dis", $newSenderBalance, $user['id'], $currency);
$stmt->execute();

// Add amount to receive
$newRecipientBalance = $recipientWallet['balance'] + $amount;
$stmt = $conn->prepare("UPDATE wallets SET balance = ? WHERE user_id = ? AND currency = ?");
$stmt->bind_param("dis", $newRecipientBalance, $recipientWallet['id'], $currency);
$stmt->execute();

// Make a transaction
$stmt = $conn->prepare("INSERT INTO transactions (sender_id, recipient_id, amount, fee, currency, type) 
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiddss", $user['id'], $recipientWallet['id'], $amount, $fee, $currency, $transferType);
$stmt->execute();

echo json_encode(["status" => "success", "message" => "Transfer successful"]);
