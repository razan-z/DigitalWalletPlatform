<?php
include("../connection/connection.php");
class Transaction
{
    private static $table_name = "transactions";
    public static function create($user_id, $receiver_id, $type, $currency, $amount)
    {

        $query = "insert into " . self::$table_name . "(user_id,receiver_id,type,currency,amount) values(?,?,?,?,?";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("iissd", $user_id, $receiver_id, $type, $currency, $amount);
        if ($stmt->execute())
            return $GLOBALS['conn']->insert_id;
        return false;
    }

    public static function read($user_id)
    {
        $query = "SELECT * FROM " . self::$table_name . " WHERE user_id = ?";
        $stmt = $GLOBALS['conn']->prepare($user_id);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
}
