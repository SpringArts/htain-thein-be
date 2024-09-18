<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Interfaces\Firebase\FirebaseInterface;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\NotiInfo;
use App\Models\User;
use Log;

class AnnouncementObserver
{
    protected User $authUser;

    protected FirebaseInterface $firebaseRepository;
    public function __construct(FirebaseInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
        $this->authUser = getAuthUserOrFail();
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
                'meta' => json_encode($announcement)
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
     * Handle the Announcement "deleting" event.
     * This runs BEFORE the announcement is deleted from the database.
     */
    public function deleting(Announcement $announcement): void
    {
        try {
            $notificationDocumentId = NotiInfo::where('announcement_id', $announcement->id)
                ->where('user_id', $this->authUser->id)
                ->first()->firebase_notification_id;

            $this->firebaseRepository->deleteNotificationDocument($notificationDocumentId, 'notifications');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

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
                'meta' => json_encode($announcement)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
