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

    public function index(): ResponseBuilder
    {
        return $this->responder->success($this->service->index($this->request->validated()));
    }

    public function show($id): ResponseBuilder
    {
        return $this->responder->success($this->service->show($id));
    }

    public function store(): ResponseBuilder
    {
        return $this->responder->success($this->service->store($this->request->validated()));
    }

    public function update($id): ResponseBuilder
    {
        $this->service->update($id, $this->request->validated());

        return $this->responder->success();
    }

    public function destroy($id): ResponseBuilder
    {
        $this->service->destroy($id);
        
        return $this->responder->success();
    }
}
