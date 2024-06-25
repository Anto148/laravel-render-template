<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('ticket_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'est_valide' => 'nullable|boolean',
            'est_adulte' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
            'projections_id' => 'nullable|exists:projections,id'
        ];
    }
}
