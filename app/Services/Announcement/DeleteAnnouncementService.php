<?php

namespace App\Services\Announcement;

use App\Helpers\ResponseHelper;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteAnnouncementService
{
    public function __invoke(AnnouncementInterface $announcementRepository, Announcement $announcement): JsonResponse
    {
        try {
            $announcementRepository->deleteAnnouncement($announcement);
            return ResponseHelper::success('Announcement deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
