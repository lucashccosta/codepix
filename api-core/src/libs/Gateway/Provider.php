<?php

namespace Libs\Gateway;

class Provider
{
    public function getTransactions()
    {
        return TransactionService::getInstance();
    }
}
