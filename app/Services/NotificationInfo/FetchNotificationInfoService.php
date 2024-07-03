<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\NotiInfoResource;
use App\Interfaces\Notification\NotificationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchNotificationInfoService
{
    public function __invoke(NotificationInterface $notiInfoResponsitory, array $formData): JsonResponse
    {
        try {
            $limit = $formData['limit'] ?? 5;
            $page = $formData['page'] ?? 1;
            $data = $notiInfoResponsitory->fetchAllNotifications($limit, $page);
            $meta = ResponseHelper::getPaginationMeta($data);

            return response()->json([
                'data' => NotiInfoResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
