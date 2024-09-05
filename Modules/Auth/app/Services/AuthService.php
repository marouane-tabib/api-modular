<?php

namespace Modules\Auth\Services;

use Flugg\Responder\Exceptions\Http\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;

class AuthService
{
    protected $auth;

    public function __construct(protected UserService $userService)
    {
        $this->auth = Auth::guard(config('auth.defaults.guard', 'api'));
    }

    public function register(array $credentials)
    {
        $token = $this->auth->login($this->userService->register($credentials));

        return $this->authInformation($token);
    }

    public function login(array $credentials)
    {
        $token = $this->auth->attempt($credentials);

        if (!$token) {
            throw new UnauthorizedException("Unauthorized");
        }

        return $this->authInformation($token);
    }

    public function logout()
    {
        return $this->auth->logout();
    }

    public function refresh()
    {
        return $this->authInformation($this->auth->refresh());
    }

    protected function authInformation($token)
    {
        $user = $this->auth->user();

        return [
            "token_type" => 'Bearer',
            "access_token" => $token,
            "user" => [
                "name" => $user->name,
                "email" => $user->email
            ]
        ];
    }
}
