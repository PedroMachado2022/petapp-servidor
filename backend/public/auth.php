<?php

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

// Token esperado (Provisório, vamos mudar isso provavelmente)
$expectedToken = 'yJhbGciOiAiSFMyNTYiLCAidHlwIjogIkpXVCIgfQ.eyJpZCI6MSwiZW1haWwiOiJwZWRyby5tYWNoYWRvLnJzQGhvdG1haWwuY29tIiwicGFzc3dvcmQiOiIxMjM0QCIsImlhdCI6MTcxNjQ4Mzg3MH0.jCFk5SeodxGb-2d6unF0QHfj0llLSvkLtPrzd4tvtvQ'; // Substitua 'seu_token_aqui' pelo token real

// Verifique se o token de autorização é válido
if ($token !== $expectedToken) {
    // 401 - Não autorizado
    http_response_code(401);
    // echo json_encode(array('message' => 'Token de autorização inválido.'));
    exit;
}

// Imprima o JSON recebido (teste de resposta)
echo 'Dados recebidos do Flutter: ' . json_encode($jsonData);
