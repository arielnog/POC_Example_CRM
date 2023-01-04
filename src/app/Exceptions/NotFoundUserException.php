<?php

namespace App\Exceptions;

use Exception;

class NotFoundUserException extends Exception
{
    /**
     * @param string|null $message
     * @param int $code
     */
    public function __construct(
        ?string $message = null,
        int $code = 404
    ) {
        $message = $message ?? 'User Not found.';
        parent::__construct($message, $code);
    }
}
