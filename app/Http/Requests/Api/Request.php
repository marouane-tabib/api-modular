<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Concerns\HasFailedValidationResponse;
use App\Http\Requests\Request as BaseRequest;

class Request extends BaseRequest
{
    use HasFailedValidationResponse;
}
