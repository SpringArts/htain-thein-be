<?php

namespace App\Repositories\Notification;

use App\Models\Report;
use App\Models\NotiInfo;
use App\Enums\ConfirmStatus;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NotificationRepository implements NotificationInterface
{
    public function fetchAllNotifications(): Collection
    {
        $data = NotiInfo::with('user', 'report')->get();
        return $data;
    }

    public function fetchUncheckedNotifications(int $userId, int $limit, int $page): LengthAwarePaginator
    {
        return NotiInfo::where('user_id', $userId)
            ->where('check_status', ConfirmStatus::UNCHECKED)
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function getUserNotification(Report $report): NotiInfo
    {
        return NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->firstOrFail();
    }

    public function createNotification(int $userId, int $reportId): NotiInfo
    {
        return NotiInfo::create([
            'user_id' => $userId,
            'report_id' => $reportId
        ]);
    }

    public function updateNotification(NotiInfo $notiInfo): bool
    {
        return $notiInfo->update([
            'check_status' => ConfirmStatus::CHECKED
        ]);
    }

    public function deleteNotification(NotiInfo $notiInfo): bool|null
    {
        return $notiInfo->delete();
    }
}
