<?php

require __DIR__ . '/../vendor/autoload.php';

use app\database\UserAuth;

// Configuração dos cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
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
$token = $jsonData['jwt'];


// Recuperamos o token do banco de dados
$expectedTokenData = UserAuth::authToken($token);

// Caso o token seja inválido, retornamos 401 e encerramos a conexão
if (!$expectedTokenData || $token !== $expectedTokenData['token']) {
    // 401 - Não autorizado
    http_response_code(401);
    exit;
}

// Imprima o JSON recebido (teste de resposta)
echo 'Dados recebidos do Flutter: ' . json_encode($expectedToken);
