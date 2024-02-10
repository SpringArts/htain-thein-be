<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'userData'      =>  new UserResource($this->whenLoaded('user')) ?? '',
            'reportData'    =>  new ReportResource($this->whenLoaded('report')) ?? '',
            'checkStatus'   => $this->check_status ?? '',
            'created_at' => $this->created_at->format('Y-d-M h:i A'),
            'updatedAt' => $this->updated_at->format('Y-d-M h:i A'),
        ];
    }
}
