<?php

namespace App\Enums;

use App\Enums\BaseEnum;

abstract class WalletTypeEnum extends BaseEnum {
    const PERSONAL = 'personal';
    const BUSINESS = 'business';
}