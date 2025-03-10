<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnnouncementObserver
{
    protected ?User $authUser;

    public function __construct()
    {
        $this->authUser = Auth::user();
    }
    public function created(Announcement $announcement): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::USER_CREATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($announcement),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the Announcement "updated" event.
     */
    public function updated(Announcement $announcement): void
    {
        try {
            $original = $announcement->getOriginal();
            $changes = $announcement->getChanges();

            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::USER_UPDATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode([
                    'original' => $original,
                    'changes' => $changes,
                ]),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the Announcement "deleting" event.
     * This runs BEFORE the announcement is deleted from the database.
     */
    public function deleting(Announcement $announcement): void {}

    /**
     * Handle the Announcement "deleted" event.
     */
    public function deleted(Announcement $announcement): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::ANNOUNCEMENT_DELETE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($announcement),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
