<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
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
            'is_active' => $this->is_active,
            'can_login' => $this->can_login,
            'roles' => $this->roles,
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
            'updated_at' => $this->updated_at?->format(config('panel.datetime_format')),
            'permissions' => $this->computed_permissions()->map(function($permission){
                return [
                    "action" => $permission['action'],
                    "resource" => $permission['resource'],
                ];
            })
        ];
    }
}
