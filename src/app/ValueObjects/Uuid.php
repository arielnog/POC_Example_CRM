<?php

namespace App\ValueObjects;

use App\Exceptions\InvalidArgumentException;
use Ramsey\Uuid\Uuid as UuidExternal;

final class Uuid
{
    private const REGEX_VALIDATE = '/^[0-9A-F]{8}-[0-9A-F]{4}-[4][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    /**
     * @param string $data
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $data
    ) {
        $this->validate();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate()
    {
        if (!preg_match(self::REGEX_VALIDATE, $this->data)) {
            throw new InvalidArgumentException('Invalid Uuid');
        }
    }

    /**
     * @param string $data
     * @return Uuid
     * @throws InvalidArgumentException
     */
    public static function fromString(string $data): Uuid
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->data;
    }

    /**
     * @return Uuid
     * @throws InvalidArgumentException
     */
    public static function generate(): Uuid
    {
        $uuid = UuidExternal::uuid4();
        return new self($uuid->toString());
    }
}
