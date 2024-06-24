<?php

namespace app\token;

use app\database\UserAuth;


class tokenValidate
{
    public static function validateToken($token)
    {
        // Recuperamos o token do banco de dados
        $expectedTokenData = UserAuth::authToken($token);

        // Caso o token seja inválido, retornamos 401 e encerramos a conexão
        if (!$expectedTokenData || $token !== $expectedTokenData['token']) {
            // 401 - Não autorizado
            http_response_code(401);
            echo json_encode(array('message' => 'Token inválido'));
            exit;
        } else {
            return null;
        }
    }
}
