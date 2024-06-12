<?php

namespace App\UseCases\Announcement;

use App\Events\AnnouncementEvent;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Illuminate\Support\Collection;

class AnnouncementAction
{
    private AnnouncementInterface $announcementRepository;

    public function __construct(AnnouncementInterface $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    public function fetchAllAnnouncements(): Collection
    {
        return $this->announcementRepository->getAllAnnouncements();
    }

    public function createAnnouncement(array $data): Announcement
    {
        $authUser = getAuthUserOrFail();
        $data['user_id'] = $authUser->id;
        $data['is_visible'] = $data['isVisible'] ?? true;
        $result = $this->announcementRepository->createAnnouncement($data);

        return $result;
    }

    public function updateAnnouncement(array $formData, Announcement $announcement): bool
    {
        $announcementData = $formData;
        return $this->announcementRepository->updateAnnouncement($announcementData, $announcement);
    }

    public function fetchAnnouncement(Announcement $announcement): Announcement
    {
        return $announcement;
    }

    public function deleteAnnouncement(Announcement $announcement): bool|null
    {
        return $this->announcementRepository->deleteAnnouncement($announcement);
    }

    public function batchDelete(array $ids): mixed
    {
        return $this->announcementRepository->batchDelete($ids);
    }
}
