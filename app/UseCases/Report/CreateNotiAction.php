<?php

namespace App\UseCases\Report;

use App\Models\NotiInfo;

class CreateNotiAction
{
    public function createNotification($userId, $reportId)
    {
        // Create the notification info
        NotiInfo::create([
            'user_id' => $userId,
            'report_id' => $reportId
        ]);
    }
}
