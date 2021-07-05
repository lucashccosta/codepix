<?php

namespace App\Exceptions;

use Exception;

class RuntimeException extends Exception
{
    public function __construct(
        ?string $message = null,
        int $code = 500
    ) {
        $message = $message ?? 'Internal server error.';
        parent::__construct($message, $code);
    }
}
