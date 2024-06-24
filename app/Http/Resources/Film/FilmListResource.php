<?php

namespace App\Http\Resources\Film;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmListResource extends JsonResource
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
            'titre' => $this->titre,
            'synopsis' => $this->synopsis,
            'duree' => $this->duree,
            'date_sortie' => $this->date_sortie,
            'cover_url' => $this->cover_url,
            'cover' => $this->cover,
            'bande_annonce' => $this->bande_annonce,
            'categorie_id' => $this->category_id,
            'categories' => $this->categories,
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
            'updated_at' => $this->updated_at?->format(config('panel.datetime_format')),
        ];
    }
}
