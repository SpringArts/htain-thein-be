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
            'userData'      =>  new UserResource($this->user) ?? '',
            'reportData'    =>  new ReportResource($this->report) ?? '',
            'checkStatus'   => $this->check_status ?? '',
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at->format('Y-d-M h:i A'),
        ];
    }
}
