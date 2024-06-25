<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Request;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Projection\ProjectionListResource;

class TicketResource extends JsonResource
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
            'est_valide' => $this->est_valide,
            'est_adulte' => $this->est_adulte,
            'projection' => new ProjectionListResource($this->whenLoaded('projection')),
            'clienr' => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
