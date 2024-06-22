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
            // RESPONDER 
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
            exit;
        }
    }

    public static function tokenAtt($newToken, $email)
    {
        try {

            $conn = Connection::getConnection();

            // Preparar a consulta SQL para atualizar o token
            $query = $conn->prepare("UPDATE users SET token = :token WHERE email = :email");
            $query->bindParam(':token', $newToken);
            $query->bindParam(':email', $email);

            $query->execute();
        } catch (PDOException $e) {
            //throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
            exit;
        }
    }

    public static function validateCargo($token)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT cargo FROM users WHERE token = :token");
            $query->bindParam(':token', $token);
            $query->execute();
            // RESPONDER 
            //return $query->fetch(PDO::FETCH_ASSOC);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['cargo'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            //throw new PDOException('Erro ao conectar ao banco de dados: ' . $e->getMessage(), (int)$e->getCode());
            exit;
        }
    }

    public static function needPasswordChange($email)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("SELECT token FROM users WHERE email = :email");
            $query->bindParam(':email', $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result && !empty($result['token'])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit;
        }
    }
}
