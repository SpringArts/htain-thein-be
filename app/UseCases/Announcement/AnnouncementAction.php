<?php

namespace App\UseCases\Announcement;

use App\Helpers\ResponseHelper;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use App\Services\Announcement\BatchDeleteAnnouncementService;
use App\Services\Announcement\DeleteAnnouncementService;
use App\Services\Announcement\FetchAnnouncementService;
use App\Services\Announcement\StoreAnnouncementService;
use App\Services\Announcement\UpdateAnnouncementService;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AnnouncementAction
{
    private AnnouncementInterface $announcementRepository;
    private NotiInfoAction $notiInfoAction;

    public function __construct(AnnouncementInterface $announcementRepository, NotiInfoAction $notiInfoAction)
    {
        $this->announcementRepository = $announcementRepository;
        $this->notiInfoAction = $notiInfoAction;
    }

    public function fetchAllAnnouncements(array $validateData): JsonResponse
    {
        try {
            return (new FetchAnnouncementService())($this->announcementRepository, $validateData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createAnnouncement(array $data): JsonResponse
    {
        try {
            return (new StoreAnnouncementService())($this->announcementRepository, $this->notiInfoAction, $data);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateAnnouncement(array $formData, Announcement $announcement): JsonResponse
    {
        try {
            return (new UpdateAnnouncementService())($this->announcementRepository, $announcement, $formData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchAnnouncement(Announcement $announcement): Announcement
    {
        return $announcement;
    }

    public function deleteAnnouncement(Announcement $announcement): JsonResponse
    {
        try {
            return (new DeleteAnnouncementService())($this->announcementRepository, $announcement);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function batchDelete(array $ids): JsonResponse
    {
        try {
            return (new BatchDeleteAnnouncementService())($this->announcementRepository, $ids);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
