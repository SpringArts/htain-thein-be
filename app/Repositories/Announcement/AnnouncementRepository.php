<?php

namespace App\Repositories\Announcement;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;

class AnnouncementRepository implements AnnouncementInterface
{
    public function getAllAnnouncements()
    {
        return Announcement::with('announcer')->where('is_visible', 1)->get();
    }


    public function createAnnouncement(array $data)
    {
        return Announcement::create($data);
    }

    public function deleteAnnouncement(Announcement $announcement)
    {
        return $announcement->delete();
    }
}
