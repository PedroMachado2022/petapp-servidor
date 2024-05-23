<?php

use app\database\UserLogin;
use app\token\tokenGenerator;
use Exception;

require '../vendor/autoload.php';
require_once '../app/database/Connection.php';
//require_once '../app/models/UserModel.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$json_data = file_get_contents('php://input');

// Verifica se o JSON foi recebido corretamente
if (!$json_data) {
    http_response_code(400);
    exit('JSON inválido ou não recebido');
}

// Decodifica o json, permitindo o acesso do PHP
$data = json_decode($json_data, true);

// Verifica se existe algum dado no arquivo
if ($data === null) {
    http_response_code(400);
    exit('JSON inválido');
}

// Verifica se o email e a senha estão presentes no JSON
if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    exit('Campos ausentes');
}

$email = $data['email'];
$password = $data['password'];

try {
    $result = UserLogin::loginVerify($email, $password);

    if ($result) {

        $tokenGenerator = new tokenGenerator($result);
        $token = $tokenGenerator->returnToken();

        // 200 - Tudo certo, aplicativo liberado
        http_response_code(200);

        // JWT
        echo json_encode($token);
    } else {
        // 400 - Campos vazios ou usuário inexistente
        http_response_code(400);
    }
} catch (Exception $e) {
    // 500 - Erro ao conectar com Mysql
    http_response_code(500);
    exit($e->getMessage());
}
