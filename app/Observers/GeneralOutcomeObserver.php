<?php

namespace App\Observers;

use App\Enums\ActivityLogType;
use App\Models\ActivityLog;
use App\Models\GeneralOutcome;
use App\Models\User;

class GeneralOutcomeObserver
{
    protected User $authUser;
    public function __construct()
    {
        $this->authUser = getAuthUserOrFail();
    }
    public function created(GeneralOutcome $generalOutcome): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REGULAR_OUTCOME_CREATE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($generalOutcome)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Handle the GeneralOutcome "updated" event.
     */
    public function updated(GeneralOutcome $generalOutcome): void
    {
        try {
            $original = $generalOutcome->getOriginal();
            $changes = $generalOutcome->getChanges();

            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REGULAR_OUTCOME_UPDATE,
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
     * Handle the GeneralOutcome "deleted" event.
     */
    public function deleted(GeneralOutcome $generalOutcome): void
    {
        try {
            ActivityLog::create([
                'user_id' => $this->authUser->id,
                'email' => $this->authUser->email,
                'type' => ActivityLogType::REGULAR_OUTCOME_DELETE,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'meta' => json_encode($generalOutcome)
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
