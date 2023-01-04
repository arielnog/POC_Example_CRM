<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    /**
     * @param string|null $message
     * @param int $code
     */
    public function __construct(
        string $message = null,
        int $code = 401
    ) {
        $message = $message ?? 'Authentication Error.';
        parent::__construct($message, $code);
    }
}
