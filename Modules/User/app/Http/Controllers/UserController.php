<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterRequest;
use Flugg\Responder\Http\Responses\SuccessResponseBuilder;
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
    /**
     * UserController constructor.
     *
     * @param UserService $service The user service instance.
     * @param Responder $responder The responder instance for building responses.
     */
    public function __construct(
        protected UserService $service,
        protected Responder $responder
    ) {
    }
    
    /**
     * Retrieve a list of all Users.
     *
     * @param FilterRequest $request The filter request instance.
     * @return SuccessResponseBuilder The success response with the list of users.
     */
    public function index(FilterRequest $request): SuccessResponseBuilder
    {
        return $this->responder->success($this->service->index($request->validated()));
    }

    /**
     * Retrieve the details of a specific User.
     *
     * @param int $id The ID of the user to retrieve.
     * @return SuccessResponseBuilder The success response with the user details.
     */
    public function show($id): SuccessResponseBuilder
    {
        return $this->responder->success($this->service->show($id));
    }

    /**
     * Create a new User with the provided data.
     *
     * @param UserStoreRequest $request The user store request instance.
     * @return SuccessResponseBuilder The success response with the created user data.
     */
    public function store(UserStoreRequest $request): SuccessResponseBuilder
    {
        return $this->responder->success($this->service->store($request->validated()));
    }

    /**
     * Update the details of an existing User.
     *
     * @param UserUpdateRequest $request The user update request instance.
     * @param int $id The ID of the user to update.
     * @return SuccessResponseBuilder The success response after updating the user.
     */
    public function update(UserUpdateRequest $request, $id): SuccessResponseBuilder
    {
        $this->service->update($id, $request->validated());

        return $this->responder->success();
    }

    /**
     * Delete the specified User from the system.
     *
     * @param int $id The ID of the user to delete.
     * @return SuccessResponseBuilder The success response after deleting the user.
     */
    public function destroy($id): SuccessResponseBuilder
    {
        $this->service->destroy($id);
        
        return $this->responder->success();
    }
}
