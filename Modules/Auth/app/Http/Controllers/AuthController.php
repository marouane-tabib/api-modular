<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Flugg\Responder\Responder;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected Responder $responder
    ) {
    }

    public function register(RegisterRequest $request)
    {
        return $this->responder->success($this->authService->register($request->validated()));
    }

    public function login(LoginRequest $request)
    {
        return $this->responder->success($this->authService->login($request->validated()));
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

