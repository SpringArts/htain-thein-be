<?php

namespace App\Services\Announcement;

use App\Helpers\ResponseHelper;
use App\Http\Resources\AnnouncementResource;
use App\Interfaces\Announcement\AnnouncementInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchAnnouncementService
{
    public function __invoke(AnnouncementInterface $announcementRepository, array $data): JsonResponse
    {
        try {
            $limit = $data['limit'] ?? 8;
            $page = $data['page'] ?? 1;
            $data = $announcementRepository->getAllAnnouncements($limit, $page);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => AnnouncementResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
