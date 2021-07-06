<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\ITransactionRepository;

class TransactionRepository extends BaseRepository implements ITransactionRepository
{
    public function model()
    {
        return Transaction::class;
    }
}
