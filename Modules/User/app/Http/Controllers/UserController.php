<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterRequest;
use Flugg\Responder\Http\Responses\ResponseBuilder;
use Flugg\Responder\Responder;
use Modules\User\Http\Requests\UserStoreRequest;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Services\UserService;

/**
 * @group User Process
 *
 * Handles operations related to User resources.
 *
 * ### Endpoints
 *
 * - **GET /User** - Retrieves a list of all Users.
 * - **GET /User/{id}** - Retrieves the details of a specific User.
 * - **POST /User** - Creates a new User with the provided data.
 * - **PUT /User/{id}** - Updates the details of an existing User.
 * - **DELETE /User/{id}** - Deletes the specified User from the system.
 *
 * All operations return standardized responses according to the API specification.
 */
class UserController extends Controller
{
    protected $service;
    protected $responder;

    public function __construct(
        UserService $service,
        Responder $responder
    ) {
        $this->service = $service;
        $this->responder = $responder;
    }
    
    public function index(FilterRequest $request): ResponseBuilder
    {
        return $this->responder->success($this->service->index($request->validated()));
    }

    public function show($id): ResponseBuilder
    {
        return $this->responder->success($this->service->show($id));
    }

    public function store(UserStoreRequest $request): ResponseBuilder
    {
        return $this->responder->success($this->service->store($request->validated()));
    }

    public function update(UserUpdateRequest $request, $id): ResponseBuilder
    {
        $this->service->update($id, $request->validated());

        return $this->responder->success();
    }

    public function destroy($id): ResponseBuilder
    {
        $this->service->destroy($id);
        
        return $this->responder->success();
    }
}
