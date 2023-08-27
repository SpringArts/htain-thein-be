<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralOutcomeResource extends JsonResource
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
            'reporter'    => $this->reporter->name ?? '',
            'description'   => $this->description ?? '',
            'amount' => $this->amount ?? 0,
            'created_at' => $this->created_at->format('Y-d-M h:i A'),
        ];
    }
}
