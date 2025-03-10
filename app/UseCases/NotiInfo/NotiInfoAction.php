<?php

namespace App\UseCases\NotiInfo;

use App\Interfaces\Firebase\FirebaseInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\Services\NotificationInfo\DeleteNotificationInfoService;
use App\Services\NotificationInfo\FetchNotificationInfoService;
use App\Services\NotificationInfo\GetAllNotificationsService;
use App\Services\NotificationInfo\MarkNotificationAsReadService;
use App\Services\NotificationInfo\StoreNotificationInfoService;
use Illuminate\Http\JsonResponse;

class NotiInfoAction
{
    private NotificationInterface $notiInfoReponsitory;

    private FirebaseInterface $firebaseRepository;

    public function __construct(
        NotificationInterface $notiInfoReponsitory,
        FirebaseInterface $firebaseRepository
    ) {
        $this->notiInfoReponsitory = $notiInfoReponsitory;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function getAllNotificationReadInfo(array $formData, int $authUserId): JsonResponse
    {
        return (new GetAllNotificationsService())($this->notiInfoReponsitory, $formData, $authUserId);
    }

    public function createNotification(array $formData): JsonResponse
    {
        return (new StoreNotificationInfoService($this->notiInfoReponsitory, $this->firebaseRepository))($formData);
    }

    public function deleteNotification(NotiInfo $notiInfo): ?bool
    {
        return (new DeleteNotificationInfoService())($this->notiInfoReponsitory, $notiInfo);
    }

    public function markNotificationAsRead(NotificationRead $notificationRead): JsonResponse
    {
        return (new MarkNotificationAsReadService($this->notiInfoReponsitory, $this->firebaseRepository))($notificationRead);
    }
}
