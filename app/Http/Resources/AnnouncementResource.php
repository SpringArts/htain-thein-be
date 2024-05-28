<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Announcement */

class AnnouncementResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'isVisible' => $this->is_visible,
            'slug' => $this->slug,
            'priority' => $this->priority,
            'userInfo' => new UserResource($this->whenLoaded('announcer')),
            'createdAt' => changeToDifferForHuman($this->created_at),
        ];
    }
}
