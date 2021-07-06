<?php

namespace App\Libs\MessageBroker\RabbitMQ;

use Anik\Amqp\ConsumableMessage;
use App\Libs\IMessageBroker;
use Illuminate\Support\Facades\Log;

class Provider implements IMessageBroker
{
    public function publish(
        $message,
        string $bindingKey,
        array $config = []
    ) {
        Builder::queue($bindingKey, $config)->emit($message);
    }

    public function consume(
        string $bindingKey,
        array $config = []
    ) {
        Builder::queue($bindingKey, $config)->receive(function ($data) {
            Log::debug(json_encode($data));
            //TODO: verify transaction status
        });
    }
}
