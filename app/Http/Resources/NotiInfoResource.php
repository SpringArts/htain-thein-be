<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\NotiInfo */
class NotiInfoResource extends JsonResource
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
            'userData' => new UserResource($this->whenLoaded('user')),
            'reportData' => new ReportResource($this->whenLoaded('report')),
            'announcementData' => new AnnouncementResource($this->whenLoaded('announcement')),
            'firebaseNotificationId' => $this->firebase_notification_id,
            'createdAt' => $this->created_at_formatted,
            'updatedAt' => $this->updated_at_formatted,
        ];
    }
}
