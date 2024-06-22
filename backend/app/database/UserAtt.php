<?php

namespace app\database;

use app\database\Connection;
use PDO;
use PDOException;

class UserAtt
{
    public static function changePassword($email, $password)
    {
        try {
            $conn = Connection::getConnection();
            $query = $conn->prepare("UPDATE users SET password = :password, token = :token WHERE email = :email");
            $token = '1';
            $query->bindParam(':token', $token);
            $query->bindParam(':password', $password);
            $query->bindParam(':email', $email);
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
