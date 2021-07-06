<?php

namespace App\Listeners;

use App\Listeners\Contracts\ITransactionListener;
use Libs\RabbitMQ\Provider as RabbitMQ;

class TransactionFailed implements ITransactionListener
{
    public function process($payload)
    {
        $payload['status'] = 'failed' ;
        (new RabbitMQ)->publish($payload, 'transactions_response');
        (new RabbitMQ)->publish($payload, 'mails');
    }
}
