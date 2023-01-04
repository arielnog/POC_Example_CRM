<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use Exception;

final class Email
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $email
    )
    {
        $this->validate();
    }


    /**
     * @throws \App\Exceptions\InvalidArgumentException
     */
    private function validate():void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid Email');
        }
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $email): Email
    {
        return new self($email);
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString()
    {
        return $this->email;
    }
}
