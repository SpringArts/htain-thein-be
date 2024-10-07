<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Interfaces\Firebase\FirebaseInterface;
use App\Models\ActivityLog;
use App\Models\NotiInfo;
use App\Models\Report;
use App\Models\User;

class ReportObserver
{
    protected User $authUser;
    protected FirebaseInterface $firebaseRepository;
    public function __construct(FirebaseInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
        $this->authUser = getAuthUserOrFail();
    }
    public function created(Report $report): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REPORT_CREATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($report)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        try {
            $original = $report->getOriginal();
            $changes = $report->getChanges();

            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REPORT_UPDATE,
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

    public function deleting(Report $report): void
    {
        try {
            $notificationDocumentId = NotiInfo::where('report_id', $report->id)
                ->where('user_id', $this->authUser->id)
                ->first()->firebase_notification_id;

            $this->firebaseRepository->deleteNotificationDocument($notificationDocumentId, 'notifications');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REPORT_DELETE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($report)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
