<?php

namespace App\Repositories\Notification;

use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationRepository implements NotificationInterface
{
    public function fetchAllNotifications(int $limit, int $page): LengthAwarePaginator
    {
        return NotiInfo::with('user', 'report', 'announcement')
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function getUserNotification(Report $report): NotiInfo
    {
        return NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->firstOrFail();
    }

    public function createNotification(int $userId, mixed $reportId, mixed $announcementId, string $firebaseNotificationId): NotiInfo
    {
        return NotiInfo::create([
            'user_id' => $userId,
            'report_id' => $reportId,
            'announcement_id' => $announcementId,
            'firebase_notification_id' => $firebaseNotificationId,
        ]);
    }

    public function deleteNotification(NotiInfo $notiInfo): ?bool
    {
        return $notiInfo->delete();
    }
}
