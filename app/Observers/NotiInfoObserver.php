<?php

namespace App\Observers;

use App\Interfaces\Firebase\FirebaseInterface;
use App\Jobs\CreateNotificationReadsJob;
use App\Models\NotiInfo;

class NotiInfoObserver
{

    private FirebaseInterface $firebaseRepository;
    public function __construct(FirebaseInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
    }
    /**
     * Handle the NotiInfo "created" event.
     */
    public function created(NotiInfo $notiInfo): void
    {
        CreateNotificationReadsJob::dispatch($notiInfo);
    }

    /**
     * Handle the NotiInfo "updated" event.
     */
    public function updated(NotiInfo $notiInfo): void
    {
        //
    }

    /**
     * Handle the NotiInfo "deleted" event.
     */
    public function deleted(NotiInfo $notiInfo): void
    {
        //
    }

    /**
     * Handle the NotiInfo "restored" event.
     */
    public function restored(NotiInfo $notiInfo): void
    {
        //
    }

    /**
     * Handle the NotiInfo "force deleted" event.
     */
    public function forceDeleted(NotiInfo $notiInfo): void
    {
        //
    }
}
