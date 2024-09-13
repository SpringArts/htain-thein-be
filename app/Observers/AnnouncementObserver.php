<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\User;

class AnnouncementObserver
{
    protected User $authUser;
    public function __construct()
    {
        $this->authUser = getAuthUserOrFail();
    }
    public function created(Announcement $announcement): void
    {
        ActivityLog::create([
            'user_id' => $this->authUser->id,
            'email' => $this->authUser->email,
            'type' => ActivityLogType::USER_CREATE,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => json_encode($announcement)
        ]);
    }

    /**
     * Handle the Announcement "updated" event.
     */
    public function updated(Announcement $announcement): void
    {
        $original = $announcement->getOriginal();
        $changes = $announcement->getChanges();

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
    }

    /**
     * Handle the Announcement "deleted" event.
     */
    public function deleted(Announcement $announcement): void
    {
        ActivityLog::create([
            'user_id' => $this->authUser->id,
            'email' => $this->authUser->email,
            'type' => ActivityLogType::ANNOUNCEMENT_DELETE,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => json_encode($announcement)
        ]);
    }
}
