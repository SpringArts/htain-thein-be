<?php

namespace App\Interfaces\Notification;

use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationInterface
{
    public function fetchAllNotifications(int $limit, int $page): LengthAwarePaginator;

    public function getUserNotification(Report $report): NotiInfo;

    public function createNotification(int $userId, mixed $reportId, mixed $announcementId, string $firebaseId): NotiInfo;

    public function deleteNotification(NotiInfo $noti): ?bool;
}
