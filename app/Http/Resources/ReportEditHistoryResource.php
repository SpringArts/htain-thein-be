<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ReportEditHistory */
class ReportEditHistoryResource extends JsonResource
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
            'editor' => $this->editUser->name ?? '',
            'reportData' => new ReportResource($this->whenLoaded('report')),
            'oldData' => is_string($this->old_data) ? json_decode($this->old_data) : '',
            'newData' => is_string($this->new_data) ? json_decode($this->new_data) : '',
            'updatedAt' => $this->updated_at ? formatDateTime($this->updated_at) : '',
        ];
    }
}
