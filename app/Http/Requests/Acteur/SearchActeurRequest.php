<?php

namespace App\Http\Requests\Acteur;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchActeurRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('acteur_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
        ];
    }
}