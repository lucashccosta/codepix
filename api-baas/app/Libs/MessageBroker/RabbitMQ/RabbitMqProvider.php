<?php

namespace App\Libs\MessageBroker\RabbitMQ;

use App\Libs\IMessageBroker;

class RabbitMqProvider implements IMessageBroker
{
    public function publish(
        string $message,
        string $bindingKey,
        array $config = []
    ) {
        app('amqp')->publish($message, $bindingKey, $config);
    }

    public function consume(
        string $queue,
        array $config = []
    ) {

    }
}
