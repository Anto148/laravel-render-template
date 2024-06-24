<?php

namespace App\Http\Resources\Film;

use Illuminate\Http\Request;
use App\Http\Resources\Acteur\ActeurResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Categorie\CategorieResource;
use App\Http\Resources\Realisateur\RealisateurResource;

class FilmShowResource extends JsonResource
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
            'bande_annonce' => $this->bande_annonce,
            'cover_url' => $this->cover_url,
            'cover' => $this->cover,
            'categorie_id' => $this->category_id,
            'categories' => CategorieResource::collection($this->whenLoaded('categories')),
            'realisateurs' => RealisateurResource::collection($this->whenLoaded('realisateurs')),
            'acteurs' => ActeurResource::collection($this->whenLoaded('acteurs')),
            'created_at' => $this->created_at?->format(config('panel.datetime_format')),
            'updated_at' => $this->updated_at?->format(config('panel.datetime_format')),
        ];
    }
}
