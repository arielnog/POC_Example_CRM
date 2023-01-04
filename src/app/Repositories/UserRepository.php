<?php

namespace App\Repositories;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    public function __construct(
        UserModel $model
    ) {
        parent::__construct($model);
    }
}
