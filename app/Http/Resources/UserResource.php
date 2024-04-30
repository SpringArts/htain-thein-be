<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        if (!$uri) return [];

        if ($uri === 'api/app/reports' || $uri === 'api/app/all-notis' || $uri === 'api/app/changed-histories' || $uri === 'api/app/uncheck-reports' || $uri === 'api/app/calculations') {
            return [
                'id' => $this->id,
                'name'    => $this->name ?? '',
            ];
        }
        if ($uri === 'api/app/users/{user}' && $request->isMethod('PUT')) {
            return [
                'id'      => $this->id,
                'name'    => $this->name ?? '',
                'email'   => $this->email ?? '',
                'role' => $this->role ?? '',
                'password' => $this->password ?? '',
                'accountStatus' => $this->account_status,
            ];
        }
        if ($uri === 'api/app/message/{receiverId?}' && $request->isMethod('GET')) {
            return [
                'id'      => $this->id,
                'name'    => $this->name ?? '',
            ];
        }
        return [
            'id'      => $this->id,
            'name'    => $this->name ?? '',
            'email'   => $this->email ?? '',
            'role' => $this->role ?? '',
            'accountStatus' => $this->account_status,
            'createdAt' => Carbon::parse($this->created_at)->format('Y-m-d'),
        ];
    }
}
