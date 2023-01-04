<?php

namespace App\ValueObjects;

use App\Enum\StatusList;
use App\Exceptions\InvalidArgumentException;
use Exception;

final class ContactStatus
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $status
    )
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (!in_array($this->status, StatusList::validValues())) {
            throw new InvalidArgumentException('Invalid Status');
        }
    }


    public function asString(): string
    {
        return $this->status;
    }

    public static function fromString(string $data)
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->asString();
    }
}
