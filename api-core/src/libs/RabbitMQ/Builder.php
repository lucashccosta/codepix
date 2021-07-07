<?php

namespace Libs\RabbitMQ;

class Builder
{
    private static $config = [];

    public static function getInstance()
    {
        self::$config = [
            'server' => [
                'host' => $_ENV['AMQP_HOST'] ?? 'localhost',
                'port' => $_ENV['AMQP_PORT'] ?? 5672,
                'user' => $_ENV['AMQP_USERNAME'] ?? 'guest',
                'pass' => $_ENV['AMQP_PASSWORD'] ?? 'guest',
                'vhost' => $_ENV['AMQP_VHOST'] ?? '/'
            ],
            'queue'    => [
                'queue'    => [
                    'passive'     => false,
                    'durable'     => true,
                    'exclusive'   => false,
                    'auto_delete' => false,
                    'nowait'      => false,
                ],
                'consumer' => [
                    'no_local'  => false,
                    'no_ack'    => false,
                    'exclusive' => false,
                    'nowait'    => false,
                ],
            ],
        ];

        return new static;
    }

    public function queue($name, $server)
    {
        return new Queue($name, self::$config);
    }
}