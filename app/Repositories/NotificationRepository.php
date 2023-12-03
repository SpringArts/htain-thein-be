<?php

namespace App\Repositories;

use App\Models\NotiInfo;
use App\Models\ReportEditHistory;
use App\Interfaces\NotificationInterface;
use App\Models\Report;

class NotificationRepository implements NotificationInterface
{

    public function updateNotification(NotiInfo $noti)
    {
        $noti->update([
            'check_status' => 1
        ]);
    }

    public function getUserNotification(Report $report)
    {
        return NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->first();
    }
}
