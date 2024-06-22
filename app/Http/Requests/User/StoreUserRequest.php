<?php

namespace App\Http\Requests\User;

use App\Traits\Requests\Requestable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use Requestable;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "nom" => "required|string|max:255",
            "prenom" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email",
            "telephone" => "required|string|max:255|unique:users,telephone",

            "roles" => "array|nullable",
            "roles.*" => "string|exists:roles,alias",

            "avatar" => "nullable|file|max:7000"
        ];
    }
}
