<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotiInfoResource;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Http\JsonResponse;

class FetchNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, array $formData, int $userId): JsonResponse
    {
        $limit = $formData['limit'] ?? 5;
        $page = $formData['page'] ?? 1;
        $data = $notiInfoResponsitory->fetchAllNotifications($limit, $page, $userId);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => NotiInfoResource::collection($data),
            'meta' => $meta,
        ]);
    }
}
