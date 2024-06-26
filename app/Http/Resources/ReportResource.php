<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Report */
class ReportResource extends JsonResource
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
        if ($uri === 'api/app/uncheck-reports') {
            return [
                'id' => $this->id,
                'amount' => $this->amount ?? 0,
                'type' => $this->type ?? '',
                'confirmStatus' => $this->confirm_status ?? '',
                'reporter' => new UserResource($this->whenLoaded('reporter')),
                'createdAt' => $this->created_at ? formatDateTime($this->created_at) : '',
            ];
        }
        if ($uri === 'api/app/user-report/{id}') {
            return [
                'id' => $this->id,
                'amount' => $this->amount ?? 0,
                'type' => $this->type ?? '',
                'reporter' => $this->reporter?->name ?? '',
                'verifier' => $this->verifier?->name ?? '',
                'createdAt' => $this->created_at ? formatDateTime($this->created_at) : '',
            ];
        }

        return [
            'id' => $this->id,
            'amount' => $this->amount ?? 0,
            'description' => $this->description ?? '',
            'type' => $this->type ?? '',
            'confirmStatus' => $this->confirm_status ?? '',
            'reporter' => new UserResource($this->reporter),
            'verifier' => new UserResource($this->verifier),
            'createdAt' => $this->created_at ? formatDateTime($this->created_at) : '',
            'updatedAt' => $this->updated_at ? formatDateTime($this->updated_at) : '',
        ];
    }
}
