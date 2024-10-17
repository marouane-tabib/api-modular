<?php

namespace Modules\User\Services;

use App\Models\Authenticatable;
use App\Services\BaseService\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\User\Repositories\UserRepository;

/**
 * Class UserService
 *
 * @package Modules\User\Services
 *
 * This service handles user-related operations and business logic.
 */
class UserService extends BaseService
{
    /**
     * @var UserRepository The user repository instance.
     */
    protected $repository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $repository The user repository instance.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Register a new user.
     *
     * @param  array           $credentials The user credentials including password.
     * @return Authenticatable The newly registered user.
     */
    public function register(array $credentials): Authenticatable
    {
        $credentials['password'] = Hash::make($credentials['password']);

        return $this->store($credentials);
    }
}
