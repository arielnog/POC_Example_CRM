<?php

namespace App\Services;

use App\Entities\Collections\ContactCollection;
use App\Entities\ContactEntity;
use App\Entities\UserEntity;
use App\Factories\Entities\ContactFactory;
use App\Repositories\ContactRepository;
use App\ValueObjects\ContactPipeline;
use App\ValueObjects\Uuid;
use Exception;
use Throwable;

class ContactService
{
    private const PARAMS_NOT_UPDATE = [
        'uuid',
        'stage',
        'pipeline',
        'status'
    ];


    public function __construct(
        protected ContactRepository $contactRepository
    ) {
    }

    public function list(): ?ContactCollection
    {
        try {
            $users = $this->contactRepository->listAll();

            if (empty($users)) {
                return null;
            }

            return ContactCollection::fromArray($users);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById(Uuid $contactId): ?ContactEntity
    {
        try {
            $contact = $this->contactRepository->getByUuid($contactId);

            if (is_null($contact)) {
                return null;
            }

            return ContactFactory::fromModel($contact);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return UserEntity
     * @throws Throwable
     */
    public function store(array $data)
    {
        try {
            $contact = ContactFactory::fromArray($data);

            $contactRepository = $this->contactRepository
                ->saveFromArray(
                    $contact->toArray()
                );

            return ContactFactory::fromModel($contactRepository);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Uuid $contactId
     * @param array $params
     * @return mixed
     * @throws Throwable
     */
    public function update(Uuid $contactId, array $params)
    {
        try {
            return $this->contactRepository
                  ->updateFromArray(
                      data: $params,
                      dataExcept: self::PARAMS_NOT_UPDATE,
                      modelUuid: $contactId
                  );
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Uuid $contactId
     * @param ContactPipeline $pipeline
     * @return mixed
     * @throws Exception
     */
    public function changePipeline(Uuid $contactId, ContactPipeline $pipeline): mixed
    {
        try {
            $contact = $this->getById($contactId);

            $contact->updatePipeline($pipeline);

            return $this->contactRepository
                ->updateFromArray(
                    data: $contact->toArray(),
                    dataExcept: [],
                    modelUuid: $contactId
                );
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function delete(Uuid $contactId)
    {
        try {
            return $this->contactRepository->deleteFromUuid(
                modelUuid: $contactId
            );
        } catch (Exception $e) {
            throw $e;
        }
    }
}
