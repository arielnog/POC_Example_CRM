<?php

namespace App\ValueObjects;

use App\Enum\SourceList;
use App\Exceptions\InvalidArgumentException;
use Exception;


final class ContactSource
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $source
    )
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (!in_array($this->source, SourceList::validValues())) {
            throw new InvalidArgumentException('Invalid Source');
        }
    }

    public function asString(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->asString();
    }
}
