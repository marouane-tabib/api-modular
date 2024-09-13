<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Flugg\Responder\Responder;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;


/**
 * @group Authentication
 *
 * Handles authentication-related operations.
 *
 * ### Endpoints
 *
 * - **POST /auth/register** - Registers a new user.
 * - **POST /auth/login** - Authenticates a user and returns a token.
 * - **POST /auth/logout** - Logs out the authenticated user.
 * - **POST /auth/refresh** - Refreshes the authentication token.
 *
 * All endpoints return standardized responses following the API specification.
 */
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

