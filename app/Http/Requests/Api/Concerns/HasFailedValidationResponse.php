<?php

namespace App\Http\Requests\Api\Concerns;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasFailedValidationResponse
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    "status" => 422,
                    "success" => false,
                    "message" => "Validation errors",
                    "errors"  => $validator->errors(),
                ],
                422
            )
        );
    }
}
