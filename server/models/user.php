<?php
include("../connection/connection.php");

class User
{
    private static $table_name = "users";

    public static function create($name, $email, $phone, $password)
    {
        global $conn;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "insert int" . self::$table_name . "(name.eamil,phone,password)values(?,?,?,?)";
        $stmt = $conn->prepare($query);

        $stmt->bind_param("ssis", $name, $email, $phone, $hashed_password);
        if ($stmt->execute())
            return $conn->insert_id;
        return false;
    }

    public static function read($id)
    {
        global $conn;
        $query = "select * from " . self::$table_name . " where id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return false;
    }



    public static function update($id, $name, $phone, $email, $verification_status, $password)
    {
        global $conn;
        $query = "update " . self::$table_name . "set name = ?, phone = ?, email = ?, verification_status = ?, password = ? where id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sisssi", $name, $phone, $email, $verification_status, $password, $id);
        return $stmt->execute();
    }
}
