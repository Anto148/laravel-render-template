<?php

namespace App\Http\Resources\Film;

use Illuminate\Http\Request;
use App\Http\Resources\Acteur\ActeurResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Categorie\CategorieResource;
use App\Http\Resources\Realisateur\RealisateurResource;

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
            'audio' => $this->audio,
            'bande_annonce' => $this->bande_annonce,
            'categorie_id' => $this->category_id,
            'categories' => CategorieResource::collection($this->whenLoaded('categories')),
            'realisateurs' => RealisateurResource::collection($this->whenLoaded('realisateurs')),
            'moyenne_note' => $this->moyenne_note,
            'acteurs' => ActeurResource::collection($this->whenLoaded('acteurs')),
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
            'updated_at' => $this->updated_at?->format(config('panel.datetime_format')),
        ];
    }
}
