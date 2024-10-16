<?php

namespace Modules\User\Repositories;

use App\Repositories\BaseRepository\BaseRepository;
use Modules\User\Models\User;

/**
 * Class UserRepository
 * 
 * @package Modules\User\Repositories
 * 
 * This repository handles database operations for the User model.
 */
class UserRepository extends BaseRepository
{
    /**
     * @var User The User model instance.
     */
    protected $model;

    /**
     * UserRepository constructor.
     * 
     * @param User $model The User model instance.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
