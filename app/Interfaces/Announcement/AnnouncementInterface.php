<?php

namespace App\Interfaces\Announcement;

use App\Models\Announcement;

interface AnnouncementInterface
{
    public function getAllAnnouncements();
    public function createAnnouncement(array $data);
    public function deleteAnnouncement(Announcement $announcement);
}
