<?php

namespace App\Repositories\Notification;

use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements NotificationInterface
{
    public function fetchAllNotifications(int $limit, int $page, int $userId): LengthAwarePaginator
    {
        return NotiInfo::with('user', 'report', 'announcement')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function getUserNotification(Report $report): NotiInfo
    {
        return NotiInfo::where('user_id', $report->reporter_id)
            ->where('report_id', $report->id)
            ->firstOrFail();
    }

    public function createNotification(int $userId, mixed $reportId = null, mixed $announcementId = null): NotiInfo
    {
        return NotiInfo::create([
            'user_id' => $userId,
            'report_id' => $reportId,
            'announcement_id' => $announcementId,
        ]);
    }

    public function deleteNotification(NotiInfo $notiInfo): ?bool
    {
        return $notiInfo->delete();
    }

    public function markAsReadNotiInfo(NotiInfo $notiInfo): bool
    {
        return $notiInfo->update(['last_viewed_at' => Carbon::now()]);
    }

    public function markAsReadNotificationRead(NotificationRead $notificationRead): bool
    {
        return $notificationRead->update(['read_at' => Carbon::now()]);
    }

    public function updateViewAndRead(NotificationRead $notificationRead): void
    {
        DB::transaction(function () use ($notificationRead) {
            $notificationRead->markAsRead();
            $notificationRead->notiInfo->updateLastViewed();
        });
    }

    public function getAllNotificationReadInfo(int $userId, ?string $cursor = null, int $limit = 10): CursorPaginator
    {
        return NotificationRead::with('notiInfo')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->cursorPaginate($limit, ['*'], 'cursor', $cursor);
    }
    public function updateNotificationReads(int $userId): int
    {
        return NotificationRead::where('user_id', $userId)->update(['read_at' => Carbon::now()]);
    }
    public function markAllAsRead(int $userId): int
    {
        return NotiInfo::where('user_id', $userId)->update(['last_viewed_at' => Carbon::now()]);
    }

    public function getUnreadCounts(int $userId): int
    {
        return NotificationRead::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }
}
