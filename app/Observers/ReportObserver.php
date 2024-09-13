<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Models\ActivityLog;
use App\Models\Report;
use App\Models\User;

class ReportObserver
{
    protected User $authUser;
    public function __construct()
    {
        $this->authUser = getAuthUserOrFail();
    }
    public function created(Report $report): void
    {
        ActivityLog::create([
            'user_id' => $this->authUser->id,
            'email' => $this->authUser->email,
            'type' => ActivityLogType::REPORT_CREATE,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => json_encode($report)
        ]);
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
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
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        ActivityLog::create([
            'user_id' => $this->authUser->id,
            'email' => $this->authUser->email,
            'type' => ActivityLogType::REPORT_DELETE,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => json_encode($report)
        ]);
    }
}
