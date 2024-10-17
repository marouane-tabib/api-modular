<?php

namespace Modules\Auth\Services;

use Flugg\Responder\Exceptions\Http\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;

/**
 * Class AuthService
 *
 * Handles authentication-related operations.
 */
class AuthService
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * AuthService constructor.
     *
     * @param UserService $userService The user service instance.
     */
    public function __construct(protected UserService $userService)
    {
        $this->auth = Auth::guard(config('auth.defaults.guard', 'api'));
    }

    /**
     * Register a new user and return authentication information.
     *
     * @param  array $credentials The user credentials for registration.
     * @return array The authentication information.
     */
    public function register(array $credentials)
    {
        $token = $this->auth->login($this->userService->register($credentials));

        return $this->authInformation($token);
    }

    /**
     * Attempt to log in a user and return authentication information.
     *
     * @param  array                 $credentials The user credentials for login.
     * @return array                 The authentication information.
     * @throws UnauthorizedException If the login attempt fails.
     */
    public function login(array $credentials)
    {
        $token = $this->auth->attempt($credentials);

        if (!$token) {
            throw new UnauthorizedException('Unauthorized');
        }

        return $this->authInformation($token);
    }

    /**
     * Log out the currently authenticated user.
     *
     */
    public function logout()
    {
        return $this->auth->logout();
    }

    /**
     * Refresh the authentication token.
     *
     * @return array The new authentication information.
     */
    public function refresh()
    {
        return $this->authInformation($this->auth->refresh());
    }

    /**
     * Generate authentication information for a given token.
     *
     * @param  string $token The authentication token.
     * @return array  The authentication information.
     */
    protected function authInformation($token)
    {
        $user = $this->auth->user();

        return [
            'token_type'   => 'Bearer',
            'access_token' => $token,
            'user'         => [
                'name'  => $user->name,
                'email' => $user->email
            ]
        ];
    }
}
