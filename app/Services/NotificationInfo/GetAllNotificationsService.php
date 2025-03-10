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
        $cursor = $formData['cursor'] ?? null;
        $limit = $formData['limit'] ?? 10;
        $notifications = $notiInfoResponsitory->getAllNotificationReadInfo($authUserId, $cursor, $limit);
        $meta = ResponseHelper::getCursorPaginationMeta($notifications);

        return response()->json([
            'data' => NotificationReadResource::collection($notifications),
            'meta' => $meta,
        ]);
    }
}
