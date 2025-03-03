<?php
include("../connection/connection.php");

class Admin
{
    private static $table_name = "admins";

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
}
