<?php

namespace App\Interfaces\Notification;

use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface NotificationInterface
{
    public function fetchAllNotifications(): Collection;
    public function fetchUncheckedNotifications(int $userId, int $limit, int $page): LengthAwarePaginator;
    public function getUserNotification(Report $report): NotiInfo;
    public function updateNotification(NotiInfo $noti): bool;
    public function createNotification(int $userId, int $reportId): NotiInfo;
    public function deleteNotification(NotiInfo $noti): bool|null;
}
