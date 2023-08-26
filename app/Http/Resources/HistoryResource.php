<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'user_id' => $this->user_id,
            'report_id' => $this->report_id,
            'oldData' => json_decode($this->old_data),
            'newData' => json_decode($this->new_data),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at
        ];
    }
}
