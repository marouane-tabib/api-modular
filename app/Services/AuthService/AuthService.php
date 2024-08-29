<?php

namespace App\Services\AuthService;

use App\Models\User;
use Flugg\Responder\Exceptions\Http\UnauthorizedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $guard;
    protected $auth;

    public function __construct()
    {
        // TODO: Change the path to modules,
        $this->auth = Auth::guard(config('auth.defaults.guard', 'api'));
    }
    
    public function register(array $credentials)
    {
        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        $token = $this->auth->login($user);

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