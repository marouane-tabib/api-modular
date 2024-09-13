<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

/**
 * @group Filtering Operations
 *
 * Handles filtering, sorting, and pagination for API requests via query parameters.
 *
 * ### Query Parameters
 * - This request accepts various query parameters: `search`, `column`, `direction`, and `paginate`.
 */
class FilterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search'    => 'nullable|string',
            'column'    => 'nullable|string|in:id',
            'direction' => 'nullable|string|in:desc,asc',
            'paginate'  => 'nullable|numeric|in:10,25,50,100,500',
        ];
    }
}
