<?php

namespace App\UseCases\NotiInfo;

use App\Interfaces\Firebase\FirebaseInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use App\Services\NotificationInfo\DeleteNotificationInfoService;
use App\Services\NotificationInfo\FetchNotificationInfoService;
use App\Services\NotificationInfo\FetchUserNotificationInfoService;
use App\Services\NotificationInfo\StoreNotificationInfoService;
use Illuminate\Http\JsonResponse;

class NotiInfoAction
{
    private NotificationInterface $notiInfoResponsitory;

    private FirebaseInterface $firebaseRepository;

    public function __construct(
        NotificationInterface $notiInfoResponsitory,
        FirebaseInterface $firebaseRepository
    ) {
        $this->notiInfoResponsitory = $notiInfoResponsitory;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function fetchAllNotifications(array $formData): JsonResponse
    {
        return (new FetchNotificationInfoService())($this->notiInfoResponsitory, $formData);
    }

    public function getUserNotification(Report $report): JsonResponse
    {
        return (new FetchUserNotificationInfoService())($this->notiInfoResponsitory, $report);
    }

    public function createNotification(array $formData): JsonResponse
    {
        return (new StoreNotificationInfoService())($this->notiInfoResponsitory, $this->firebaseRepository, $formData);
    }

    public function deleteNotification(NotiInfo $notiInfo): JsonResponse
    {
        return (new DeleteNotificationInfoService())($this->notiInfoResponsitory, $notiInfo);
    }
}
