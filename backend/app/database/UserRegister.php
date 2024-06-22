<?php

namespace app\database;

use app\database\Connection;
use PDO;
use PDOException;

class UserRegister
{
    public static function registerUser($nome, $matricula, $email, $cargo)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("INSERT INTO users (nome, password, matricula, email, cargo) VALUES (:nome, '0000', :matricula, :email, :cargo)");
            $query->bindParam(':nome', $nome);
            $query->bindParam(':matricula', $matricula);
            $query->bindParam(':email', $email);
            $query->bindParam(':cargo', $cargo);
            $query->execute();
            return true;
        } catch (PDOException $e) {
            throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
        }
    }
}
