<?php

namespace app\token;

class tokenGenerator
{
    private $header;
    private $payload;
    private $signature;
    private $tokenGenerated = false;
    private $userData;

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    private function generateToken()
    {
        $this->header = $this->base64UrlEncode('{"alg": "HS256", "typ": "JWT" }');
        $payloadData = array_merge($this->userData, ['iat' => time()]);
        $this->payload = $this->base64UrlEncode(json_encode($payloadData));
        $this->signature = $this->base64UrlEncode(
            hash_hmac('sha256', $this->header . '.' . $this->payload, 'key', true)
        );

        $this->tokenGenerated = true;
    }

    private function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public function returnToken()
    {
        if (!$this->tokenGenerated) {
            $this->generateToken();
        }

        return $this->header . '.' . $this->payload . '.' . $this->signature;
    }
}

// $userData = [
//     'name' => 'Pedro Machado',
//     'email' => 'pedro@example.com'
// ];

// $auth = new \app\token\tokenGenerator($userData);
// echo "Token gerado: " . $auth->returnToken();
