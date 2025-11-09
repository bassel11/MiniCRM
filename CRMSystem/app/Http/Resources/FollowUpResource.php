<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpResource extends JsonResource
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
            'user' => $this->user?->name,
            'due_at' => $this->due_at->toDateTimeString(),
            'notes' => $this->notes,
            'done' => $this->done,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
