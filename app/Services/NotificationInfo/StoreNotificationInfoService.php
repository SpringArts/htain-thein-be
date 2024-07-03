<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, FirebaseChattingInterface $firebaseRepository, array $formData): JsonResponse
    {
        try {
            $firebaseNotificationId = $this->createNotification($firebaseRepository, $formData);
            $notiInfoResponsitory->createNotification(
                $formData['user_id'],
                $formData['report_id'] ?? null,
                $formData['announcement_id'] ?? null,
                $firebaseNotificationId
            );
            return ResponseHelper::success('Notification created successfully', null, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createNotification(FirebaseChattingInterface $firebaseRepository, array $formData): string
    {
        return $firebaseRepository->storeNotification($formData);
    }
}
