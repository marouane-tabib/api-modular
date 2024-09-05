<?php

namespace Modules\User\Services;

use App\Models\Authenticatable;
use App\Services\BaseService\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\User\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(array $credentials): Authenticatable
    {
        $credentials['password'] = Hash::make($credentials['password']);

        return $this->store($credentials);
    }
}
