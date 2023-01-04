<?php

namespace App\Factories\Entities;

use App\Entities\ContactEntity;
use App\Entities\UserEntity;
use App\Models\User;
use App\Traits\Iterator;
use App\ValueObjects\ContactPipeline;
use App\ValueObjects\ContactSource;
use App\ValueObjects\ContactStage;
use App\ValueObjects\ContactStatus;
use App\ValueObjects\Email;
use App\ValueObjects\Uuid;
use Exception;
use Illuminate\Database\Eloquent\Model;


class ContactFactory
{
    use Iterator;

    /**
     * @param array $data
     * @return \App\Entities\ContactEntity
     * @throws Exception
     */
    public static function fromArray(array $data): ContactEntity
    {
        $uuid = self::getData($data, 'uuid');
        $email = self::getData($data, 'email');
        $source = self::getData($data, 'source');
        $stage = self::getData($data, 'stage');
        $status = self::getData($data, 'status');
        $pipeline = self::getData($data, 'pipeline');

        return new ContactEntity(
            uuid: !is_null($uuid) ? Uuid::fromString($uuid) : Uuid::generate(),
            name: self::getData($data, 'name'),
            email: new Email($email),
            source: new ContactSource($source),
            stage: new ContactStage($stage),
            status: new ContactStatus($status),
            pipeline: !is_null($pipeline) ? new ContactPipeline($pipeline) : null
        );
    }

    /**
     * @param User $userModel
     * @return UserEntity
     * @throws Exception
     */
    public static function fromModel(Model $contactModel): ContactEntity
    {
        return self::fromArray($contactModel->toArray());
    }

}
