<?php

namespace App\Libs\MessageBroker\RabbitMQ;

class Builder
{
    private static $defaults = [
        'server' => [
            'host' => 'localhost',
            'port' => 5672,
            'user' => 'guest',
            'pass' => 'guest',
            'vhost' => 'bank_codepix'
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

    public static function queue($name, $server)
    {
        // $conf = self::$defaults['queue'];
        // $conf['server'] = $server;

        return new Queue($name, self::$defaults);
    }
}