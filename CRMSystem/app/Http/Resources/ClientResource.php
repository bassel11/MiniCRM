<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'assigned_to' => $this->assignedTo?->name,
            'last_communication_at' => optional($this->last_communication_at)->toDateTimeString(),
            'communications_count' => $this->communications()->count(),
            'follow_ups_count' => $this->followUps()->count(),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
