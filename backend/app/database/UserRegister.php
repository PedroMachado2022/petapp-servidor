<?php

namespace app\database;

use app\database\Connection;
use PDO;
use PDOException;

class UserRegister
{
    public static function registerUser($nome, $matricula, $email)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("INSERT INTO users (nome, matricula) VALUES (:nome, :matricula, :email)");
            $query->bindParam(':nome', $nome);
            $query->bindParam(':matricula', $matricula);
            $query->bindParam(':email', $email);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
        }
    }
}
