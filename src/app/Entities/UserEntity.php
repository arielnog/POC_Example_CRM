<?php

namespace App\Entities;

use App\ValueObjects\Email;
use App\ValueObjects\Uuid;

class UserEntity
{
    /**
     * @param Uuid $uuid
     * @param string $name
     * @param Email $email
     * @param string|null $password
     * @param int|null $id
     */
    public function __construct(
        protected Uuid $uuid,
        protected string $name,
        protected Email $email,
        protected ?string $password,
        protected ?int $id = null
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->toString(),
            'name' => $this->name,
            'email' => $this->email->toString(),
            'password' => $this->password,
        ];

    }
}
