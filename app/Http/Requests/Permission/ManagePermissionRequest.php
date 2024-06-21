<?php

namespace App\Http\Requests\Permission;

use App\Models\Permission;
use App\Traits\Requests\Requestable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ManagePermissionRequest extends FormRequest
{
    use Requestable;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('permission_manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|integer|exists:users,id",
            "permission_ids" => "required|nullable",
            "permission_ids.*" => "integer|exists:permissions,id",
            "action" => "required|string|in:".implode(",", Permission::MANAGE_ACTIONS),
        ];
    }
}

