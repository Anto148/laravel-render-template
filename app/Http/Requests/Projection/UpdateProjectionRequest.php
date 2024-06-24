<?php

namespace App\Http\Requests\Projection;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('projection_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_projection' => 'nullable|date',
            'heure_projection' => 'nullable',
            'en_3d' => 'nullable|boolean',
            'film_id' => 'nullable|exists:films,id',
            'salle_id' => 'nullable|exists:salles,id',
            'type_projection_id' => 'nullable|exists:type_projections,id',
        ];
    }
}
