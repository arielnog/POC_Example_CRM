<?php

namespace App\ValueObjects;

use App\Enum\StageList;
use App\Exceptions\InvalidArgumentException;
use Exception;

final class ContactStage
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $stage
    )
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (!in_array($this->stage, StageList::validValues())) {
            throw new InvalidArgumentException('Invalid Stage');
        }
    }

    public function asString(): string
    {
        return $this->stage;
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
