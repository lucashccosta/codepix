<?php

namespace App\Libs\MessageBroker\RabbitMQ;

class Builder
{
    private static $config = [];

    public static function getInstance()
    {
        self::$config = [
            'server' => [
                'host' => env('AMQP_HOST', 'localhost'),
                'port' => env('AMQP_PORT', 5672),
                'user' => env('AMQP_USERNAME', 'guest'),
                'pass' => env('AMQP_PASSWORD', 'guest'),
                'vhost' => env('AMQP_VHOST', '/')
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