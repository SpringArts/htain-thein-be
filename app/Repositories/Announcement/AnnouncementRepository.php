<?php

namespace App\Repositories\Announcement;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use Request;

class AnnouncementRepository implements AnnouncementInterface
{
    public function getAllAnnouncements()
    {
        return Announcement::with('announcer')->get();
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
