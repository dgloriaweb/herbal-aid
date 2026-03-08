<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return a list of the tree of the species using the species.parent_id and its rank and name

        return [
            'id' => $this->id,
            'scientific_name' => $this->scientific_name,
            'species' => [
                'id' => $this->species?->id,
                'name' => $this->species?->name,
                'formatted' => $this->species ? strtoupper($this->species->name) : null,
            ],
            'created_at' => $this->created_at,
        ];
            

    }
}
