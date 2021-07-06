<?php

namespace Libs\Gateway;

class Response
{
    private $statusCode;
    private $payload;

    public function __construct(int $statusCode, $payload) 
    {
        $this->statusCode = $statusCode;
        $this->payload = $payload;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}