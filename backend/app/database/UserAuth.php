<?php

namespace app\database;

use app\database\Connection;
use PDO;
use PDOException;

class UserAuth
{
    public static function authToken($token)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT token FROM users WHERE token = :token");
            $query->bindParam(':token', $token);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
        }
    }
}
