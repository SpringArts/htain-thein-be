<?php

namespace App\UseCases\NotiInfo;

use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class NotiInfoAction
{
    private NotificationInterface $notiInfoResponsitory;

    public function __construct(
        NotificationInterface $notiInfoResponsitory
    ) {
        $this->notiInfoResponsitory = $notiInfoResponsitory;
    }

    public function fetchAllNotifications(): Collection
    {
        return $this->notiInfoResponsitory->fetchAllNotifications();
    }

    public function fetchUncheckedNotifications(array $formData, int $userId): LengthAwarePaginator
    {
        $limit = $formData['limit'] ?? 8;
        $page = $formData['page'] ?? 1;
        return $this->notiInfoResponsitory->fetchUncheckedNotifications($userId, $limit, $page);
    }

    public function getUserNotification(Report $report): NotiInfo
    {
        return $this->notiInfoResponsitory->getUserNotification($report);
    }

    public function createNotification(array $formData): NotiInfo
    {
        $userId = $formData['user_id'];
        $reportId = $formData['report_id'];
        return $this->notiInfoResponsitory->createNotification($userId, $reportId);
    }

    public function updateNotification(NotiInfo $notiInfo): bool
    {
        return $this->notiInfoResponsitory->updateNotification($notiInfo);
    }

    public function deleteNotification(NotiInfo $notiInfo): bool|null
    {
        return $this->notiInfoResponsitory->deleteNotification($notiInfo);
    }
}
