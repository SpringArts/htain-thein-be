<?php

namespace App\Interfaces\Notification;

use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

interface NotificationInterface
{
    public function fetchAllNotifications(int $limit, int $page, int $userId): LengthAwarePaginator;

    public function getUserNotification(Report $report): NotiInfo;

    public function createNotification(int $userId, mixed $reportId = null, mixed $announcementId = null, string $firebaseNotificationId): NotiInfo;

    public function deleteNotification(NotiInfo $notiInfo): ?bool;

    public function updateViewAndRead(NotificationRead $notificationRead): void;

    public function getAllNotifications(int $userId, ?string $cursor = null): CursorPaginator;
}
