<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id'      => $this->id,
            'editor'    => $this->editUser->name ?? '',
            'reportData'   =>  new ReportResource($this->report) ?? '',
            'oldData' => json_decode($this->old_data) ?? '',
            'newData' => json_decode($this->new_data) ?? '',
            'updatedAt' => $this->updated_at->format('Y-d-M h:i A'),
        ];
    }
}
