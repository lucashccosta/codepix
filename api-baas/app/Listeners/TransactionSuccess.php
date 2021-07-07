<?php

namespace App\Listeners;

use App\Enums\TransactionStatusEnum;
use App\Listeners\Contracts\ITransactionListener;
use App\Repositories\Contracts\ITransactionRepository;
use App\Repositories\Contracts\IWalletRepository;

class TransactionSuccess implements ITransactionListener
{
    public function process($payload)
    {
        $walletRepository = app()->make(IWalletRepository::class);
        $transactionRepository = app()->make(ITransactionRepository::class);
        $walletRepository->increment(
            $payload['wallet_to'],
            'balance',
            (float) $payload['total']
        );

        $transactionRepository->update(
            $payload['transaction'], 
            ['status' => TransactionStatusEnum::SUCCESS]
        );
    }   
}
