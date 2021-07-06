<?php

namespace App\Listeners;

use App\Listeners\Contracts\ITransactionListener;
use App\Repositories\Contracts\IWalletRepository;

class TransactionSuccess implements ITransactionListener
{
    public function process($payload)
    {
        $walletRepository = app()->make(IWalletRepository::class);
        $walletRepository->increment(
            $payload['wallet_to'],
            'balance',
            (float) $payload['total']
        );
    }
}
