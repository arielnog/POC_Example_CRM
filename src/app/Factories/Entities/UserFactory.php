<?php

namespace App\Factories\Entities;

use App\Entities\UserEntity;
use App\Models\User;
use App\Traits\Iterator;
use App\ValueObjects\Email;
use App\ValueObjects\Uuid;
use Exception;


class UserFactory
{
    use Iterator;

    /**
     * @param array $data
     * @return UserEntity
     * @throws Exception
     */
    public static function fromArray(array $data): UserEntity
    {
        $uuid = self::getData($data, 'uuid');
        $email = self::getData($data, 'email');

        return new UserEntity(
            uuid: !is_null($uuid) ? Uuid::fromString($uuid) : Uuid::generate(),
            name: self::getData($data, 'name'),
            email: new Email($email),
            password: self::getData($data, 'password')
        );
    }

    /**
     * @param User $userModel
     * @return UserEntity
     * @throws Exception
     */
    public static function fromModel(User $userModel): UserEntity
    {
        return self::fromArray($userModel->toArray());
    }

}
