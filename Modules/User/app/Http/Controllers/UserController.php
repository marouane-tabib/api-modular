<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Api\Controller as ApiController;
use Flugg\Responder\Responder;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Services\UserService;

class UserController extends ApiController
{
    protected $service, $request, $responder;

    public function __construct(
        UserService $service, UserRequest $request, Responder $responder
    ) {
        $this->service = $service;
        $this->request = $request;
        $this->responder = $responder;
    }
}
