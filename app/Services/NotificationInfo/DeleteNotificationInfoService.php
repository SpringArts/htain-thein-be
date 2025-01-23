<?php

namespace App\Services\NotificationInfo;

use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;

class DeleteNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, NotiInfo $notiInfo): ?bool
    {
        return $notiInfoResponsitory->deleteNotification($notiInfo);
    }
}
