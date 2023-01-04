<?php

namespace App\Exceptions;

use Exception;

class InvalidArgumentException extends Exception
{
    /**
     * @param string|null $message
     * @param int $code
     */
    public function __construct(
        ?string $message = null,
        int $code = 400
    ) {
        $message = $message ?? 'Invalid Parameter.';
        parent::__construct($message, $code);
    }
}
