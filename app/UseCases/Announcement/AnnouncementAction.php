<?php

namespace App\UseCases\Announcement;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;

class AnnouncementAction
{
    private AnnouncementInterface $announcementRepository;

    public function __construct(AnnouncementInterface $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    public function fetchAllAnnouncements()
    {
        return $this->announcementRepository->getAllAnnouncements();
    }

    public function createAnnouncement(array $data): Announcement
    {
        $authUser = auth()->user();
        $data['user_id'] = $authUser->id;
        $data['is_visible'] = $data['isVisible'] ?? true;
        return $this->announcementRepository->createAnnouncement($data);
    }

    public function updateAnnouncement(array $formData, Announcement $announcement): int
    {
        $announcementData = $formData;
        return $this->announcementRepository->updateAnnouncement($announcementData, $announcement);
    }

    public function fetchAnnouncement(Announcement $announcement): Announcement
    {
        return $announcement;
    }

    public function deleteAnnouncement(Announcement $announcement): int
    {
        return $this->announcementRepository->deleteAnnouncement($announcement);
    }
}
