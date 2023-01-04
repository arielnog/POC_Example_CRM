<?php

namespace App\Exceptions;

use Exception;

class RunTimeException extends Exception
{
    /**
     * @param string|null $message
     * @param int $code
     */
    public function __construct(
        ?string $message = null,
        int $code = 500
    ) {
        $message = $message ?? 'Internal server error.';
        parent::__construct($message, $code);
    }
}
