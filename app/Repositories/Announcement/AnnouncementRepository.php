<?php

namespace App\Repositories\Announcement;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;

class AnnouncementRepository implements AnnouncementInterface
{
    public function getAllAnnouncements()
    {
        $authUser = auth()->user();
        if ($authUser->role === 'SuperAdmin') {
            return Announcement::with('announcer')->orderBy('created_at', 'desc')->get();
        }
        return Announcement::with('announcer')->where('is_visible', 1)->orderBy('created_at', 'desc')->get();
    }


    public function createAnnouncement(array $data)
    {
        return Announcement::create($data);
    }

    public function updateAnnouncement(array $formData, Announcement $announcement)
    {
        return $announcement->update($formData);
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        return $announcement->delete();
    }
}
