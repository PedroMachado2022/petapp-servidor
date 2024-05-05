<?php

use app\database\Connection;

require_once '../app/database/Connection.php';

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
    // Criar uma nova conexão usando a classe Connection
    $conn = Connection::getConnection();

    // Aqui você pode usar a variável $email e $password para realizar consultas ou operações no banco de dados
    // Exemplo:
    $queryFinally = $conn->prepare("SELECT * FROM emails WHERE email = :email");
    $queryFinally->bindParam(':email', $email);
    // $queryFinally->bindParam(':senha', $password);
    $queryFinally->execute();
    $result = $queryFinally->fetch(PDO::FETCH_ASSOC);

    if ($result != 0) {
        $response = ['mensagem' => 'PETiano detectado, pode logar!'];
    } else {
        $response = ['mensagem' => 'Sai fora maluco!'];
    }

    //$response = ['mensagem' => 'Dados recebidos com sucesso'];
    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Erro ao conectar ao banco de dados');
}
