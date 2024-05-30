<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'message'      =>  $this->message ?? '',
            'senderInfo'   =>  new UserResource($this->whenLoaded('sender')),
            'createdAt' =>  changeToDifferForHuman($this->created_at),
        ];
    }
}
