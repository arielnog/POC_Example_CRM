<?php

namespace App\Entities\Collections;

use App\Entities\UserEntity;
use App\Factories\Entities\UserFactory;
use Illuminate\Support\Collection;

class UserCollection extends Collection
{
    protected $items = [];

    public function __construct(UserEntity ...$users)
    {
        parent::__construct($users);
    }

    public function addClient(UserEntity $user): self
    {
        $this->items[] = $user;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public static function fromArray(array $userArray): self
    {
        $userEntities = [];

        foreach ($userArray as $user) {
            $userEntities[] = UserFactory::fromArray($user);
        }

        return new self(...$userEntities);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        if (empty($this->items)) {
            return [];
        }

        return array_map(
            fn($item) => $item->toArray(),
            $this->items
        );
    }
}
