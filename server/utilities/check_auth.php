<?php
require("../connection/connection.php");
function checkAuth()
{
    global $conn;
    $headers = getallheaders();
    $token = $headers["Authorization"] ?? "";

    $stmt = $conn->prepare("SELECT * FROM users WHERE token = ?");

    $stmt->execute([$token]);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (!$user) {
            return json_encode([
                "status" => "error",
                "message" => "Invalid token"
            ]);
        }
        return json_encode([
            "status" => "success",
            "user_id" => $user['id'],
        ]);
    }
}
