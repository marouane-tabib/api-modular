<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository\BaseRepository;
use Modules\User\Models\User;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
