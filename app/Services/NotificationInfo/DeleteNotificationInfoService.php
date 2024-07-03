<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotiInfo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, NotiInfo $notiInfo): JsonResponse
    {
        try {
            $notiInfoResponsitory->deleteNotification($notiInfo);
            return ResponseHelper::success('Notification deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
