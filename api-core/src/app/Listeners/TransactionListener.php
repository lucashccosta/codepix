<?php

namespace App\Listeners;

use App\Listeners\Contracts\ITransactionListener;

class TransactionListener
{
    /**
     * @var ITransactionListener
     */
    private $listener;

    public function __construct(string $status)
    {
        $status = ucfirst($status);
        $class = "App\Listeners\Transaction{$status}";
        $this->listener = new $class;
    }

    public function listen($payload)
    {
        return $this->listener->process($payload);
    }
}