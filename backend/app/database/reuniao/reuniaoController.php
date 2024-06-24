<?php


namespace app\database\reuniao;

use app\database\Connection;

use PDO;
use PDOException;

class reuniaoController
{
    public static function createReuniao($id)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("INSERT INTO reuniao (host, flag, created) VALUES (:host, 1, NOW())");
            $query->bindParam(':host', $id);
            $query->execute();
            // Verifica se alguma linha foi afetada
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function validateFlag()
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT * FROM reuniao WHERE flag = 1");
            $query->execute();
            // Verifica se alguma linha foi afetada
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
