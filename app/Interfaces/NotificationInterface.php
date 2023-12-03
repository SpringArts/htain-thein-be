<?php

namespace App\Interfaces;

use App\Models\NotiInfo;
use App\Models\Report;

interface NotificationInterface
{
    public function updateNotification(NotiInfo $noti);
    public function getUserNotification(Report $report);
}
