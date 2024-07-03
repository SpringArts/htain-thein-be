<?php

namespace App\Services\Announcement;

use App\Helpers\ResponseHelper;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateAnnouncementService
{
    public function __invoke(AnnouncementInterface $announcementRepository, Announcement $announcement, array $formData,): JsonResponse
    {
        try {
            $announcementRepository->updateAnnouncement($formData, $announcement);
            return ResponseHelper::success('Announcement updated successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
