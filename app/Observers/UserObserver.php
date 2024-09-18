<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Models\ActivityLog;
use App\Models\User;

class UserObserver
{
    protected User $authUser;
    public function __construct()
    {
        $this->authUser = getAuthUserOrFail();
    }
    public function created(User $user): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::USER_CREATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($user)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        try {
            $original = $user->getOriginal();
            $changes = $user->getChanges();

            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' =>  ActivityLogType::USER_UPDATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode([
                    'original' => $original,
                    'changes' => $changes
                ])
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::USER_DELETE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($user)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
