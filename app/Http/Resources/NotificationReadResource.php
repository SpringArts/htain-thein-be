<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationReadResource extends JsonResource
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
            'detailInfo' => new NotiInfoResource($this->whenLoaded('notiInfo')),
            'readAt' => $this->read_at,
            'createdAt' => changeToDifferForHuman($this->created_at),
        ];
    }
}
