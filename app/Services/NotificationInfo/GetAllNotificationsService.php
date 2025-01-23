<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotificationReadResource;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Http\JsonResponse;

class GetAllNotificationsService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, array $formData, int $authUserId): JsonResponse
    {
        $cursor = $formData['cursor'] ?? 1;
        $notifications = $notiInfoResponsitory->getAllNotifications($authUserId, $cursor);
        $meta = ResponseHelper::getCursorPaginationMeta($notifications);

        return response()->json([
            'data' => NotificationReadResource::collection($notifications),
            'meta' => $meta,
        ]);
    }
}
