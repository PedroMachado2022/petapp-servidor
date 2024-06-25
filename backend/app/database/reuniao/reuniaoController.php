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

    public static function endReuniao()
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("UPDATE reuniao SET flag = 0, finalized = NOW() WHERE flag = 1");
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

    public static function returnQrCode()
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT * FROM reuniao WHERE flag = 1");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            //throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
            exit;
        }
    }

    public static function getAllReuniao()
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT * FROM reuniao");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            //throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
            exit;
        }
    }
}
