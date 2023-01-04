<?php

namespace App\Services;

use App\Entities\Collections\UserCollection;
use App\Entities\UserEntity;
use App\Factories\Entities\UserFactory;
use App\Repositories\UserRepository;
use App\ValueObjects\Uuid;
use Exception;
use Throwable;

class UserService
{
    private const PARAMS_NOT_UPDATE = [
        'uuid'
    ];


    public function __construct(
        protected UserRepository $userRepository
    ) {
    }

    public function list()
    {
        try {
            $users = $this->userRepository->listAll();

            if (empty($users)) {
                return null;
            }

            return UserCollection::fromArray($users);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function getById(Uuid $userId): ?UserEntity
    {
        try {
            $user = $this->userRepository->getByUuid($userId);

            if (is_null($user)) {
                return null;
            }

            return UserFactory::fromModel($user);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return UserEntity
     * @throws Throwable
     */
    public function save(array $data)
    {
        try {
            $user = UserFactory::fromArray($data);

            $userRepository = $this->userRepository
                ->saveFromArray(
                    $user->toArray()
                );

            return UserFactory::fromModel($userRepository);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @throws Exception|Throwable
     */
    public function update(Uuid $clientUuid, array $params)
    {
        try {
            $userRepository = $this->userRepository
                ->updateFromArray(
                    data: $params,
                    dataExcept: self::PARAMS_NOT_UPDATE,
                    modelUuid: $clientUuid
                );

            return $userRepository;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @throws Throwable
     */
    public function delete(Uuid $clientUuid)
    {
        try {
            return $this->userRepository->deleteFromUuid(
                modelUuid: $clientUuid
            );
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
