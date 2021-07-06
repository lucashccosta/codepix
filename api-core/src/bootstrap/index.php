<?php

use App\Listeners\TransactionListener;
use Libs\RabbitMQ\Provider as RabbitMQ;
use Libs\Gateway\Provider as Gateway;

$rabbitmq = (new RabbitMQ)->consume(
    'transactions_request',
    function ($data) {
        $response = (new Gateway)->getTransactions()->create(
            $data['wallet_from'],
            $data['wallet_to'],
            $data['total']
        );

        $status = !in_array($response->getStatusCode(), [200, 201]) ? 'failed' : 'success';
        (new TransactionListener($status))->listen($data);
    }
);