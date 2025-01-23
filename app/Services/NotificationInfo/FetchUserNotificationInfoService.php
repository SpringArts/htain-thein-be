<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotiInfoResource;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\Report;
use Illuminate\Http\JsonResponse;

class FetchUserNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, Report $report): JsonResponse
    {
        $userNotification = $notiInfoResponsitory->getUserNotification($report);

        return ResponseHelper::success('Successfully Fetched', new NotiInfoResource($userNotification), 200);
    }
}
