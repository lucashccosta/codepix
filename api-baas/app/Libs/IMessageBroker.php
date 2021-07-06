<?php

namespace App\Libs;

interface IMessageBroker
{
    public function publish(
        $message, 
        string $queue,
        array $config = []
    );
    public function consume(
        string $queue,
        callable $callable,
        array $config = []
    );
}