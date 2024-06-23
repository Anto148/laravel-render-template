<?php

namespace App\Http\Requests\Role;

use App\Traits\Requests\Requestable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchRoleRequest extends FormRequest
{
    use Requestable;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('role_search');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => "nullable|string",
            "alias" => "nullable|string",
            "description" => "nullable|string",
        ];
    }
}