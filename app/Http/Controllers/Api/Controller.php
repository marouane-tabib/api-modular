<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\Api\Request as ApiRequest;
use App\Services\BaseService\Interfaces\Service;

class Controller extends BaseController
{    
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index(ApiRequest $request)
    {
        return $this->service->index($request->validated());
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(ApiRequest $request)
    {
        return $this->service->store($request->validated());
    }

    public function update(ApiRequest $request, $id)
    {
        return $this->service->update($id, $request->validated());
    }
    
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
