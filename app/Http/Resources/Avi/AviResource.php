<?php

namespace App\Http\Resources\Avi;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AviResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
