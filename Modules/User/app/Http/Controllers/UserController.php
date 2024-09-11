<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterRequest;
use Flugg\Responder\Responder;
use Flugg\Responder\Http\Responses\ResponseBuilder;
use Modules\User\Http\Requests\UserStoreRequest;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Services\UserService;

class UserController extends Controller
{
    protected $service, $responder;

    public function __construct(
        UserService $service, Responder $responder
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
