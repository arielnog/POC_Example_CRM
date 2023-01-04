<?php

namespace App\Entities\Collections;

use App\Entities\ContactEntity;
use App\Factories\Entities\ContactFactory;
use Illuminate\Support\Collection;

class ContactCollection extends Collection
{
    protected $items = [];

    public function __construct(ContactEntity ...$contacts)
    {
        parent::__construct($contacts);
    }

    public function addClient(ContactEntity $contact): self
    {
        $this->items[] = $contact;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public static function fromArray(array $contactArray): self
    {
        $contactEntities = [];

        foreach ($contactArray as $contact) {
            $contactEntities[] = ContactFactory::fromArray($contact);
        }

        return new self(...$contactEntities);
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
