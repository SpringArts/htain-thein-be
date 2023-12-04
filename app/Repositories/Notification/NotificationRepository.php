<?php

namespace App\Repositories\Notification;

use App\Enums\ConfirmStatus;
use App\Models\NotiInfo;
use App\Interfaces\NotificationInterface;
use App\Models\Report;

class NotificationRepository implements NotificationInterface
{

    public function updateNotification(NotiInfo $noti)
    {
        $noti->update([
            'check_status' => ConfirmStatus::CHECKED
        ]);
    }

    public function getUserNotification(Report $report)
    {
        return NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->first();
    }

    public function createNotification(int $userId, int $reportId)
    {
        // Create the notification info
        NotiInfo::create([
            'user_id' => $userId,
            'report_id' => $reportId
        ]);
    }
}
