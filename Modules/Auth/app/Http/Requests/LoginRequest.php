<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|min:5|max:100|exists:users,email',
            'password' => 'required|string|min:8|max:100',
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
