<?php

namespace Modules\User\Services;

use App\Services\BaseService\BaseService;
use Modules\User\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}

