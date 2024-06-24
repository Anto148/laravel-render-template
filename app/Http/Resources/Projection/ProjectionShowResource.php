<?php

namespace App\Http\Resources\Projection;

use Illuminate\Http\Request;
use App\Http\Resources\Film\FilmListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TypeProjection\TypeProjectionResource;

class ProjectionShowResource extends JsonResource
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
            'date_projection' => $this->date_projection,
            'en_3d' => $this->en_3d,
            'film' => new FilmListResource($this->whenLoaded('film')),
            // 'salle' => new SalleResource($this->whenLoaded('salle')),
            'type_projection' => new TypeProjectionResource($this->whenLoaded('typeProjection')),
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
            'updated_at' => $this->updated_at?->format(config('panel.datetime_format')),
        ];
    }
}
