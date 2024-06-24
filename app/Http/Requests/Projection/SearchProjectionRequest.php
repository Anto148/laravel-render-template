<?php

namespace App\Http\Requests\Projection;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchProjectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('projection_search');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_projection' => 'sometimes|date',
            'heure_projection' => 'sometimes',
            'film_id' => 'sometimes|integer|exists:films,id',
            'salle_id' => 'sometimes|integer|exists:salles,id',
            'type_projection_id' => 'sometimes|integer|exists:type_projections,id',
            'per_page' => 'sometimes|integer|max:100',
        ];
    }
}
