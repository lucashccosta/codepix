<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Contracts\IWalletRepository;

class WalletRepository extends BaseRepository implements IWalletRepository
{
    public function model()
    {
        return Wallet::class;
    }
}
