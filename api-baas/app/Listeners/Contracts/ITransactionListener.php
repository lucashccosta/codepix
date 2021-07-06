<?php

namespace App\Listeners\Contracts;

interface ITransactionListener
{
    public function process($payload);
}