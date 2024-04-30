<?php

namespace App\UseCases\Announcement;

use App\Events\AnnouncementEvent;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Log;

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

    public function createAnnouncement(array $data)
    {
        $authUser = auth()->user();
        $data['user_id'] = $authUser->id;
        $data['is_visible'] = $data['isVisible'] ?? true;
        $message = $this->announcementRepository->createAnnouncement($data);
        event(new AnnouncementEvent($message, $authUser));
        Log::info('Announcement created by ' . $authUser->name);
        return $message;
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

    public function batchDelete(array $ids): int
    {
        return $this->announcementRepository->batchDelete($ids);
    }
}
