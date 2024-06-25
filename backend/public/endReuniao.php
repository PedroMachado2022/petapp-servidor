<?php

require __DIR__ . '/../vendor/autoload.php';

use app\database\UserAuth;
use app\database\reuniao\reuniaoController;
use app\token\tokenValidate;

// Configuração dos cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");

// Aceita a solicitação
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Pegamos o json com os dados da autenticação
$data = file_get_contents('php://input');
$jsonData = json_decode($data, true);

// Verifique se o JSON foi decodificado corretamente
if ($jsonData === null) {
    // 400 - Erro nos dados
    http_response_code(400);
    // echo json_encode(array('message' => 'Erro ao decodificar o JSON.'));
    exit;
}

// Pegamos o campo JWT do Json 
$token = $jsonData['token'];

// Validação do token
$expectedTokenData = tokenValidate::validateToken($token);
$validate = UserAuth::validateCargo($token);
if ($validate['cargo'] == 'master') {
    try {

        // Verifica se existe alguma reunião ativa
        $validateFlag = reuniaoController::validateFlag();
        // Caso haja uma reunião ativa, não permite uma nova criação
        if ($validateFlag) {
            $endReuniao = reuniaoController::endReuniao();
            http_response_code(200);
        } else {
            exit();
        }
    } catch (Exception $e) {
        echo $e;
    }
}
