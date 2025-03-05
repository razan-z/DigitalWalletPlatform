<?php
include("../connection/connection.php");

class Wallet
{
    private static $table_name = "wallets";

    public static function create($user_id, $currency, $balance)
    {
        $query = "insert into " . self::$table_name . "(user_id, currency, balance) values(?,?,?)";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("isd", $user_id, $currency, $balance);
        if ($stmt->execute())
            return $GLOBALS['conn']->insert_id;
        return false;
    }

    public static function read($id)
    {
        $query = "select * from " . self::$table_name . "where id = ?";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public static function update($id, $currency, $balance)
    {
        $query = "update " . self::$table_name . " set balance = ? where id = ? and currency = ?";
        $stmt = $GLOBALS['conn']->prepare($query);
        $stmt->bind_param("isd", $balance, $balance, $id);
        if ($stmt->execute())
            return $GLOBALS['conn']->insert_id;
        return false;
    }
}
