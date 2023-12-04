<?php

namespace App\Interfaces\Notification;

use App\Models\NotiInfo;
use App\Models\Report;

interface NotificationInterface
{
    public function updateNotification(NotiInfo $noti);
    public function getUserNotification(Report $report);
    public function createNotification(int $userId, int $reportId);
}
