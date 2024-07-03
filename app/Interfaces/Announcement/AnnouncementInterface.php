<?php

namespace App\Interfaces\Announcement;

use App\Models\Announcement;
use Illuminate\Pagination\LengthAwarePaginator;

interface AnnouncementInterface
{
    public function getAllAnnouncements(int $limit, int $page): LengthAwarePaginator;

    public function createAnnouncement(array $data): Announcement;

    public function updateAnnouncement(array $formData, Announcement $announcement): bool;

    public function deleteAnnouncement(Announcement $announcement): ?bool;

    public function batchDelete(array $ids): mixed;
}
