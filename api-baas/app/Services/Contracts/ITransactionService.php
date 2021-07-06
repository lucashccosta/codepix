<?php

namespace App\Services\Contracts;

use App\Models\User;

interface ITransactionService
{
    public function create(User $user, array $data);
}