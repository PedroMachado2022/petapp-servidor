<?php

use app\database\UserAtt;

require '../vendor/autoload.php';
require_once '../app/database/Connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$json_data = file_get_contents('php://input');


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
    $passwordAtt = UserAtt::changePassword($email, $password);
    file_put_contents('teste.txt', $passwordAtt);
    if ($passwordAtt) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
} catch (PDOException $e) {
    http_response_code(500);
}
