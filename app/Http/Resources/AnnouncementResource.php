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
        /** @var string|null $uri */
        $uri = $request->route()?->uri;
        if (! $uri) {
            return [];
        }

        // Only include companyName and companyStatus for /api/org
        if ($uri === 'api/app/all-notifications') {
            return [
                'id' => $this->id,
                'slug' => $this->slug,
                'priority' => $this->priority,
                'dueDate' => $this->due_date,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'isVisible' => $this->is_visible,
            'slug' => $this->slug,
            'priority' => $this->priority,
            'dueDate' => $this->due_date,
            'userInfo' => new UserResource($this->whenLoaded('announcer')),
            'createdAt' => changeToDifferForHuman($this->created_at),
        ];
    }
}
