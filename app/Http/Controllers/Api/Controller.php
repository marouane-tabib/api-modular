<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Request as ApiRequest;
use App\Services\BaseService\Interfaces\Service;
use Flugg\Responder\Responder;

class Controller extends BaseController
{
    public function __construct(
        protected Service $service,
        protected Responder $responder
    ) {
    }

    public function index(ApiRequest $request)
    {
        return $this->responder->success($this->service->index($request->validated()));
    }

    public function show($id)
    {
        return $this->responder->success($this->service->show($id));
    }

    public function store(ApiRequest $request)
    {
        return $this->responder->success($this->service->store($request->all()));
    }

    public function update(ApiRequest $request, $id)
    {
        return $this->responder->success($this->service->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return $this->responder->success($this->service->destroy($id));
    }
}
