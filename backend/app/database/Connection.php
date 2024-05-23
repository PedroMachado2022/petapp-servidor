<?php

namespace app\database;

use PDO;
use PDOException;

class Connection
{
    private static $conn;

    public static function connect()
    {
        $host = 'localhost';
        $db_name = 'petapp';
        $username = 'root';
        $password = '';

        try {
            self::$conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully to MySQL!" . PHP_EOL;
            return self::$conn;
        } catch (PDOException $e) {
            //echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public static function getConnection()
    {
        if (!self::$conn) {
            self::connect();
        }
        return self::$conn;
    }
}
