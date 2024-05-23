<?php

namespace app\token;

class tokenGenerator
{
    private $header;
    private $payload;
    private $signature;
    private $tokenGenerated = false;

    private function generateToken()
    {
        $this->header = $this->base64UrlEncode('{"alg": "HS256", "typ": "JWT" }');
        $this->payload = $this->base64UrlEncode('{"name": "Pedro Machado", "iat": ' . time() . '}');
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


// $auth = new \app\token\tokenGenerator();
// echo "Token gerado: " . $auth->returnToken();
