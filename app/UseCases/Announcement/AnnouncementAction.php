<?php

namespace App\UseCases\Announcement;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Support\Collection;

class AnnouncementAction
{
    private AnnouncementInterface $announcementRepository;

    private NotiInfoAction $notiInfoAction;

    public function __construct(AnnouncementInterface $announcementRepository, NotiInfoAction $notiInfoAction)
    {
        $this->announcementRepository = $announcementRepository;
        $this->notiInfoAction = $notiInfoAction;
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
        $data['due_date'] = $data['dueDate'];

        $result = $this->announcementRepository->createAnnouncement($data);

        $this->notiInfoAction->createNotification([
            'user_id' => $authUser->id,
            'announcement_id' => $result->id,
            'type' => 'announcement',
        ]);

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

    public function deleteAnnouncement(Announcement $announcement): ?bool
    {
        return $this->announcementRepository->deleteAnnouncement($announcement);
    }

    public function batchDelete(array $ids): mixed
    {
        return $this->announcementRepository->batchDelete($ids);
    }
}
