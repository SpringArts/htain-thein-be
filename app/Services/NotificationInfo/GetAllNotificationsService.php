<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotificationReadResource;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetAllNotificationsService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, array $formData, int $authUserId): JsonResponse
    {
        $cursor = $formData['cursor'] ?? null;
        Log::info($cursor);

        $limit = $formData['limit'] ?? 10;
        $notifications = $notiInfoResponsitory->getAllNotifications($authUserId, $cursor, $limit);
        $meta = ResponseHelper::getCursorPaginationMeta($notifications);

        return response()->json([
            'data' => NotificationReadResource::collection($notifications),
            'meta' => $meta,
        ]);
    }
}
