<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'roles' => $this->roles,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
        ];
    }
}
