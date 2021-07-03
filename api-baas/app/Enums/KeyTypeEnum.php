<?php

namespace App\Enums;

use App\Enums\BaseEnum;

abstract class KeyTypeEnum extends BaseEnum {
    const DOC = 'doc';
    const EMAIL = 'email';
    const PHONE = 'phone';
}