<?php

namespace App\UseCases\NotiInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Firebase\FirebaseInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\Models\Report;
use App\Services\NotificationInfo\DeleteNotificationInfoService;
use App\Services\NotificationInfo\FetchNotificationInfoService;
use App\Services\NotificationInfo\FetchUserNotificationInfoService;
use App\Services\NotificationInfo\GetAllNotificationsService;
use App\Services\NotificationInfo\StoreNotificationInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

    public function fetchAllNotifications(array $formData, int $userId): JsonResponse
    {
        $limit = 10;
        $page = 1;

        return (new FetchNotificationInfoService())($this->notiInfoReponsitory, $formData, $userId);
    }

    public function getUserNotification(Report $report): JsonResponse
    {
        return (new FetchUserNotificationInfoService())($this->notiInfoReponsitory, $report);
    }

    public function createNotification(array $formData): JsonResponse
    {
        return (new StoreNotificationInfoService())($this->notiInfoReponsitory, $this->firebaseRepository, $formData);
    }

    public function deleteNotification(NotiInfo $notiInfo): ?bool
    {
        return (new DeleteNotificationInfoService())($this->notiInfoReponsitory, $notiInfo);
    }

    public function markNotificationAsRead(NotificationRead $notificationRead): JsonResponse
    {
        try {
            $this->notiInfoReponsitory->updateViewAndRead($notificationRead);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ResponseHelper::success('Notification marked as read successfully', null, Response::HTTP_OK);
    }

    public function getAllNotifications(array $formData, int $authUserId): JsonResponse
    {
        return (new GetAllNotificationsService())($this->notiInfoReponsitory, $formData, $authUserId);
    }
}
