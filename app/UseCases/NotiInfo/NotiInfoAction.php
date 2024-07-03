<?php

namespace App\UseCases\NotiInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use App\Services\NotificationInfo\DeleteNotificationInfoService;
use App\Services\NotificationInfo\FetchNotificationInfoService;
use App\Services\NotificationInfo\FetchUserNotificationInfoService;
use App\Services\NotificationInfo\StoreNotificationInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

    public function fetchAllNotifications(array $formData): JsonResponse
    {
        try {
            return (new FetchNotificationInfoService())($this->notiInfoResponsitory, $formData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserNotification(Report $report): JsonResponse
    {
        try {
            return (new FetchUserNotificationInfoService())($this->notiInfoResponsitory, $report);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createNotification(array $formData): JsonResponse
    {
        try {
            return (new StoreNotificationInfoService())($this->notiInfoResponsitory, $this->firebaseRepository, $formData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteNotification(NotiInfo $notiInfo): JsonResponse
    {
        try {
            return (new DeleteNotificationInfoService())($this->notiInfoResponsitory, $notiInfo);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
