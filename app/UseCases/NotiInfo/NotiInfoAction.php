<?php

namespace App\UseCases\NotiInfo;

use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use Illuminate\Pagination\LengthAwarePaginator;

class NotiInfoAction
{
    private NotificationInterface $notiInfoResponsitory;

    private FirebaseChattingInterface $firebaseRepository;

    public function __construct(
        NotificationInterface $notiInfoResponsitory,
        FirebaseChattingInterface $firebaseRepository
    ) {
        $this->notiInfoResponsitory = $notiInfoResponsitory;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function fetchAllNotifications(array $formData): LengthAwarePaginator
    {
        $limit = $formData['limit'] ?? 5;
        $page = $formData['page'] ?? 1;

        return $this->notiInfoResponsitory->fetchAllNotifications($limit, $page);
    }

    public function getUserNotification(Report $report): NotiInfo
    {
        return $this->notiInfoResponsitory->getUserNotification($report);
    }

    public function createNotification(array $formData): NotiInfo
    {
        $userId = $formData['user_id'];
        $reportId = $formData['report_id'] ?? null;
        $announcementId = $formData['announcement_id'] ?? null;

        $firebaseNotificationId = $this->firebaseRepository->storeNotification($formData);

        return $this->notiInfoResponsitory->createNotification($userId, $reportId, $announcementId, $firebaseNotificationId);
    }

    public function deleteNotification(NotiInfo $notiInfo): ?bool
    {
        return $this->notiInfoResponsitory->deleteNotification($notiInfo);
    }
}
