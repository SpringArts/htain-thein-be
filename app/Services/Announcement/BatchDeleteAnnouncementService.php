<?php

namespace App\Services\Announcement;

use App\Helpers\ResponseHelper;
use App\Interfaces\Announcement\AnnouncementInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BatchDeleteAnnouncementService
{
    public function __invoke(AnnouncementInterface $announcementRepository, array $ids): JsonResponse
    {
        try {
            $announcementRepository->batchDelete($ids);
            return ResponseHelper::success('Announcements deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
