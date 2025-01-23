<?php

namespace App\Jobs;

use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateNotificationReadsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected NotiInfo $notiInfo;

    public function __construct(NotiInfo $notiInfo)
    {
        $this->notiInfo = $notiInfo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::pluck('id')->chunk(100)->map(function ($userIds): void {
            foreach ($userIds as $userId) {
                NotificationRead::firstOrCreate([
                    'user_id' => $userId,
                    'noti_info_id' => $this->notiInfo->id,
                ]);
            }
        });
    }
}
