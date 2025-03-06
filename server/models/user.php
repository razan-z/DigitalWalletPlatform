<?php
require("../connection/connection.php");
require("./wallet.php");

class User
{
    public static function create($email, $phone, $password)
    {
        $query = "SELECT * FROM users WHERE email = ? AND phone = ?";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return [
                "status" => "error",
                "message" => "Email or phone number have already been used"
            ];
        }


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $token = bin2hex(random_bytes(32));

        $query = "INSERT INTO users (email, phone, password, token) VALUES (?,?,?,?)";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("siss",  $email, $phone, $hashed_password, $token);
        if ($stmt->execute()) {
            $user_id = $GLOBALS['conn']->insert_id;

            // create 2 wallets for the user
            $usd_wallet = Wallet::create($user_id, "USD", 0.00);
            $lbp_wallet = Wallet::create($user_id, "LBP", 0.00);

            if ($usd_wallet && $lbp_wallet) {
                return [
                    "status" => "success",
                    "token" => $token,
                    "user_id" => $user_id
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "User created, but wallets could not be created"
                ];
            }
        } else {
            return [
                "status" => "error",
                "message" => "Error creating user"
            ];
        }
    }

    public static function read($token)
    {

        $query = "select * from users where token = ?";

        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public static function update($id, $name, $phone, $email, $verification_status, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "update users set name = ?, phone = ?, email = ?, verification_status = ?, password = ? where id = ?";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("sisssi", $name, $phone, $email, $verification_status, $hashed_password, $id);
        return $stmt->execute();
    }
}
