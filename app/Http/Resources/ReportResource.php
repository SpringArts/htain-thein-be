<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        if (!$uri) return [];

        // Only include companyName and companyStatus for /api/org
        if ($uri === 'api/app/uncheck-reports') {
            return [
                'id' => $this->id,
                'amount' => $this->amount ?? 0,
                'type' => $this->type ?? '',
                'confirmStatus' => $this->confirm_status ?? '',
                'reporter' => new UserResource($this->reporter) ?? '',
                'createdAt' => $this->created_at->format('Y-d-M h:i A'),
            ];
        }
        if ($uri === 'api/app/user-report/{id}') {
            return [
                'id' => $this->id,
                'amount' => $this->amount ?? 0,
                'type' => $this->type ?? '',
                'reporter' => $this->reporter->name ?? '',
                'verifier' => $this->verifier->name ?? '',
                'createdAt' => $this->created_at->format('Y-d-M h:i A'),
            ];
        }
        return [
            'id' => $this->id,
            'amount' => $this->amount ?? 0,
            'description' => $this->description ?? '',
            'type' => $this->type ?? '',
            'confirmStatus' => $this->confirm_status ?? '',
            'reporter' => new UserResource($this->reporter) ?? '',
            'verifier' => new UserResource($this->verifier) ?? '',
            'createdAt' => $this->created_at->format('Y-d-M h:i A'),
            'updatedAt' => $this->updated_at->format('Y-d-M h:i A'),
        ];
    }
}
