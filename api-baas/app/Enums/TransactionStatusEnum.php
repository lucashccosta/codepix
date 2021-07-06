<?php

namespace App\Enums;

use App\Enums\BaseEnum;

abstract class TransactionStatusEnum extends BaseEnum {
    const PROCESSING = 'processing';
    const FAILED = 'failed';
    const SUCCESS = 'success';
}