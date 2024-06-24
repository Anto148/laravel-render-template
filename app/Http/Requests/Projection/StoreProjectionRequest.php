<?php

namespace App\Http\Requests\Projection;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('projection_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_projection' => 'required|date',
            'heure_projection' => 'required',
            'en_3d' => 'required|boolean',
            'film_id' => 'required|exists:films,id',
            // 'salle_id' => 'required|exists:salles,id',
            'type_projection_id' => 'required|exists:type_projections,id',
        ];
    }
}
