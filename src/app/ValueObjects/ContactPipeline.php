<?php

namespace App\ValueObjects;

use App\Enum\PipelineList;
use App\Exceptions\InvalidArgumentException;
use Exception;

final class ContactPipeline
{
    /**
     * @throws Exception
     */
    public function __construct(
        private string $pipeline
    )
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    private function validate(): void
    {
        if (!in_array($this->pipeline, PipelineList::validValues())) {
            throw new InvalidArgumentException('Invalid Pipeline');
        }
    }

    public function asString(): ?string
    {
        return $this->pipeline;
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
