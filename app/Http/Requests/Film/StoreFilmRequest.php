<?php

namespace App\Http\Requests\Film;

use App\Traits\Requests\Requestable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreFilmRequest extends FormRequest
{
    use Requestable;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('film_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:255',
            'synopsis' => 'nullable|string|max:255',
            'duree' => 'nullable|integer',
            'bande_annonce'=> 'nullable|string|max:255',
            'cover' => 'nullable|image|max:7000',
        ];
    }
}
