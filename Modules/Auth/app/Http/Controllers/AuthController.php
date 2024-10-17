<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
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
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService The authentication service.
     * @param Responder   $responder   The responder for building responses.
     */
    public function __construct(
        protected AuthService $authService,
        protected Responder $responder
    ) {
    }

    /**
     * Register a new user.
     *
     * @param  RegisterRequest        $request The registration request.
     * @return SuccessResponseBuilder The success response with registration data.
     */
    public function register(RegisterRequest $request): SuccessResponseBuilder
    {
        return $this->responder->success($this->authService->register($request->validated()));
    }

    /**
     * Authenticate a user and return a token.
     *
     * @param  LoginRequest           $request The login request.
     * @return SuccessResponseBuilder The success response with login data.
     */
    public function login(LoginRequest $request): SuccessResponseBuilder
    {
        return $this->responder->success($this->authService->login($request->validated()));
    }

    /**
     * Log out the authenticated user.
     *
     * @return SuccessResponseBuilder The success response after logout.
     */
    public function logout(): SuccessResponseBuilder
    {
        return $this->responder->success($this->authService->logout());
    }

    /**
     * Refresh the authentication token.
     *
     * @return SuccessResponseBuilder The success response with refreshed token data.
     */
    public function refresh(): SuccessResponseBuilder
    {
        return $this->responder->success($this->authService->refresh());
    }
}
