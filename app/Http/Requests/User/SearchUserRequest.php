<?php

namespace App\Http\Requests\User;

use App\Traits\Requests\Requestable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
{
    use Requestable;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'periode' => 'nullable|array',
            'periode.from' => 'nullable|date',
            'periode.to' => 'nullable|date',

            'email' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'fullname' => 'nullable|string|max:255',

            'role_ids' => 'array|nullable',
            'role_ids.*' => 'required|exists:roles,id',

            'roles' => 'array|nullable',
            'roles.*' => 'required|exists:roles,alias',

            'per_page' => 'nullable|numeric|max:100',
        ];
    }
}