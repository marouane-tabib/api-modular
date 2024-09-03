<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Request as ApiRequest;
use App\Services\BaseService\Interfaces\Service;
use Flugg\Responder\Http\Responses\ResponseBuilder;
use Flugg\Responder\Responder;

class Controller extends BaseController
{
    protected $service, $request, $responder;

    public function __construct(
        Service $service, ApiRequest $request, Responder $responder
    ) {
        $this->service = $service;
        $this->request = $request;
        $this->responder = $responder;
    }

    public function index(ApiRequest $request): ResponseBuilder
    {
        return $this->responder->success($this->service->index($request->validated()));
    }

    public function show($id): ResponseBuilder
    {
        return $this->responder->success($this->service->show($id));
    }

    public function store(ApiRequest $request): ResponseBuilder
    {
        return $this->responder->success($this->service->store($request->validated()));
    }

    public function update(ApiRequest $request, $id): ResponseBuilder
    {
        return $this->responder->success($this->service->update($id, $request->validated()));
    }

    public function destroy($id): ResponseBuilder
    {
        return $this->responder->success($this->service->destroy($id));
    }
}
