<?php

namespace App\Libs\MessageBroker\RabbitMQ;

use Anik\Amqp\ConsumableMessage;
use App\Libs\IMessageBroker;
use Illuminate\Support\Facades\Log;

class Provider implements IMessageBroker
{
    public function publish(
        $message,
        string $queue,
        array $config = []
    ) {
        Builder::queue($queue, $config)->emit($message);
    }

    public function consume(
        string $queue,
        callable $callback,
        array $config = []
    ) {
        Builder::queue($queue, $config)->receive(
            function ($data) use($callback) {
                Log::debug(json_encode($data));
                call_user_func($callback, $data);
            }
        );
    }
}
