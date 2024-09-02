<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService\AuthService;
use Flugg\Responder\Responder;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected Responder $responder
    ) {
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return $this->responder->success($this->authService->register($credentials));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        return $this->responder->success($this->authService->login($credentials));
    }

    public function logout()
    {
        return $this->responder->success($this->authService->logout());
    }

    public function refresh()
    {
        return $this->responder->success($this->authService->refresh());
    }
}
