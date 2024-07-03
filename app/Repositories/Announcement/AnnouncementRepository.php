<?php

namespace App\Repositories\Announcement;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Illuminate\Pagination\LengthAwarePaginator;

class AnnouncementRepository implements AnnouncementInterface
{
    public function getAllAnnouncements(int $limit, int $page): LengthAwarePaginator
    {
        $authUser = getAuthUserOrFail();
        if ($authUser->role === 'SuperAdmin') {
            return Announcement::with('announcer')->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
        }
        return Announcement::with('announcer')->where('is_visible', 1)->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function createAnnouncement(array $data): Announcement
    {
        return Announcement::create($data);
    }

    public function updateAnnouncement(array $formData, Announcement $announcement): bool
    {
        return $announcement->update($formData);
    }

    public function deleteAnnouncement(Announcement $announcement): ?bool
    {
        return $announcement->delete();
    }

    public function batchDelete(array $ids): mixed
    {
        return Announcement::whereIn('id', $ids)->delete();
    }
}
