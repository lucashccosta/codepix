<?php

namespace App\Validators;

class TransactionValidator
{
    const CREATE = [
        'key_code' => 'required',
        'key_type' => 'required',
        'total' => 'required'
    ];
}

