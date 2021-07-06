<?php

namespace App\Libs;

interface IMessageBroker
{
    public function publish(
        $message, 
        string $bindingKey,
        array $config = []
    );
    public function consume(
        string $bindingKey,
        array $config = []
    );
}