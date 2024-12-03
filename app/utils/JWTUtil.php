<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTUtil
{
    private $secret;
    private $algorithm;
    private $expiry;

    public function __construct($config)
    {
        $this->secret = $config['jwt_secret'];
        $this->algorithm = $config['algorithm'];
        $this->expiry = $config['expiry'];
    }

    public function generateToken($payload)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $this->expiry;

        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key($this->secret, $this->algorithm));
        } catch (\Exception $e) {
            return null;
        }
    }
}
