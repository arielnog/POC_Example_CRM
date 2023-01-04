<?php

namespace App\Repositories;

use App\ValueObjects\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

abstract class BaseRepository
{
    protected function __construct(
        protected Model $model
    ) {
    }

    public function listAll()
    {
        return $this->model
            ->get()
            ->toArray();
    }

    /**
     * @param Uuid $uuid
     * @return mixed
     */
    public function getByUuid(Uuid $uuid): mixed
    {
        return $this->model
            ->where('uuid', $uuid->toString())
            ->get()
            ->first();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function saveFromArray(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param array $dataExcept
     * @param Uuid $modelUuid
     * @return mixed
     */
    public function updateFromArray(
        array $data,
        array $dataExcept,
        Uuid $modelUuid
    ): mixed {
        return $this->model
            ->where('uuid', $modelUuid->toString())
            ->update(
                Arr::except(
                    $data,
                    $dataExcept
                )
            );
    }

    /**
     * @param Uuid $modelUuid
     * @return mixed
     */
    public function deleteFromUuid(Uuid $modelUuid): mixed
    {
        return $this->model
            ->where('uuid', $modelUuid->toString())
            ->delete();
    }
}
