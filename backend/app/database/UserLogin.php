<?php

namespace app\database;

use app\database\Connection;
use PDO;
use PDOException;


class UserLogin
{
    public static function loginVerify($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException('Erro ao conectar ao banco de dados' . $e->getMessage(), (int)$e->getCode());
        }
    }
}
