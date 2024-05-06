<?php

namespace app\token;

class tokenAuth
{
    public function generate()
    {
        $header = $this->base64UrlEncode('{"alg": "HS256", "typ": "JWT" }');
        $payload = $this->base64UrlEncode('{"name": "Pedro Machado", "iat": ' . time() . '}');
        $signature = $this->base64UrlEncode(
            hash_hmac('sha256', $header . '.' . $payload, 'key', true)
        );

        echo $header . '.' . $payload . '.' . $signature;
    }

    private function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}

// $auth = new tokenAuth();
// $auth->generate();
