<?php

namespace Libs\RabbitMQ;

class Provider
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
                call_user_func($callback, $data);
            }
        );
    }
}
