<?php

namespace App\Auth;

use App\Exceptions\InvalidJwtException;
use Exception;
use Firebase\JWT\JWT;
use stdClass;

class JwtToken
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var stdClass
     */
    public $payload;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->parseToken();
    }

    private function parseToken()
    {
        try {
            $jwt = JWT::decode($this->token, env('JWT_SECRET'), ['HS256']);
            $this->payload = $jwt;
        } catch (Exception $e) {
            throw new InvalidJwtException();
        }
    }
}
