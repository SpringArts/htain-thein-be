<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
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
        if (!$uri) {
            return [];
        }

        if ($uri === 'api/app/reports' || $uri === 'api/app/general-outcomes'  || $uri === 'api/app/all-notis' || $uri === 'api/app/changed-histories' || $uri === 'api/app/uncheck-reports' || $uri === 'api/app/calculations') {
            return [
                'id' => $this->id,
                'name' => $this->name ?? '',
            ];
        }
        if ($uri === 'api/app/users/{user}' && $request->isMethod('PUT')) {
            return [
                'id' => $this->id,
                'name' => $this->name ?? '',
                'email' => $this->email ?? '',
                'role' => $this->role ?? '',
                'password' => $this->password ?? '',
                'accountStatus' => $this->account_status,
            ];
        }
        if ($uri === 'api/app/message/{receiverId?}' && $request->isMethod('GET')) {
            return [
                'id' => $this->id,
                'name' => $this->name ?? '',
            ];
        }

        if ($uri === 'api/app/general-outcome/{general_outcome}' && $request->isMethod('GET')) {
            return [
                'id' => $this->id,
                'name' => $this->name ?? '',
            ];
        }
        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'role' => $this->role ?? '',
            'accountStatus' => $this->account_status,
            'createdAt' => $this->created_at ? formatDate($this->created_at) : '',
        ];
    }
}
