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
        return (new FetchAnnouncementService())($this->announcementRepository, $validateData);
    }

    public function createAnnouncement(array $data): JsonResponse
    {
        return (new StoreAnnouncementService())($this->announcementRepository, $this->notiInfoAction, $data);
    }

    public function updateAnnouncement(array $formData, Announcement $announcement): JsonResponse
    {
        return (new UpdateAnnouncementService())($this->announcementRepository, $announcement, $formData);
    }

    public function fetchAnnouncement(Announcement $announcement): Announcement
    {
        return $announcement;
    }

    public function deleteAnnouncement(Announcement $announcement): JsonResponse
    {
        return (new DeleteAnnouncementService())($this->announcementRepository, $announcement);
    }

    public function batchDelete(array $ids): JsonResponse
    {
        return (new BatchDeleteAnnouncementService())($this->announcementRepository, $ids);
    }
}
