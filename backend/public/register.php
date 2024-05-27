<?php

require __DIR__ . '/../vendor/autoload.php';

use app\database\UserRegister;

// Configuração dos cabeçalhos CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With");

// Aceita a solicitação
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$data = file_get_contents('php://input');
$jsonData = json_decode($data, true);

// Verifique se o JSON foi decodificado corretamente
if ($jsonData === null) {
    // 400 - Erro nos dados
    http_response_code(400);
    echo json_encode(array('message' => 'erro.'));
    exit;
}

if (!isset($jsonData['nome'], $jsonData['matricula'], $jsonData['email'])) {
    // 400 - Campos incompletos
    http_response_code(400);
    // echo json_encode(array('message' => 'Campos incompletos.'));
    exit;
}

$nome = $jsonData['nome'];
$matricula = $jsonData['matricula'];
$email = $jsonData['email'];

// Chame a função para registrar o usuário
try {
    $result = UserRegister::registerUser($email, $password, $email);
    if ($result) {
        // 200 - Sucesso ao registrar o usuário
        http_response_code(200);
        echo json_encode(array('message' => 'Usuário registrado com sucesso.'));
    } else {
        // 500 - Erro ao registrar o usuário
        http_response_code(500);
        // echo json_encode(array('message' => 'Erro ao registrar o usuário.'));
    }
} catch (PDOException $e) {
    // 500 - Erro no servidor
    http_response_code(500);
    // echo json_encode(array('message' => 'Erro no servidor: ' . $e->getMessage()));
}
