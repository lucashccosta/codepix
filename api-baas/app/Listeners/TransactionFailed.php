<?php

namespace App\Listeners;

use App\Listeners\Contracts\ITransactionListener;
use App\Repositories\Contracts\IWalletRepository;

class TransactionFailed implements ITransactionListener
{
    public function process($payload)
    {
        $walletRepository = app()->make(IWalletRepository::class);
        $walletRepository->increment(
            $payload['wallet_from'],
            'balance',
            (float) $payload['total']
        );
    }
}
