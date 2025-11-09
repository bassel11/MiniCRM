<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunicationResource extends JsonResource
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
            'client' => $this->client?->name,
            'type' => $this->type,
            'date' => $this->date->toDateTimeString(),
            'notes' => $this->notes,
            'created_by' => $this->creator?->name,
        ];
    }
}
