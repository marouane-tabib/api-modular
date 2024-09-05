<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\Api\Request as ApiRequest;

class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:50',
            'email' => 'required|email|min:5|max:100|unique:users,email',
            'password' => 'required|string|min:8|max:100|confirmed',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
