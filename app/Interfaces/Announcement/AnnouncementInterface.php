<?php

namespace App\Interfaces\Announcement;

use App\Models\Announcement;

interface AnnouncementInterface
{
    public function getAllAnnouncements();
    public function createAnnouncement(array $data);
    public function updateAnnouncement(array $formData, Announcement $announcement);
    public function deleteAnnouncement(Announcement $announcement);
    public function batchDelete(array $ids);
}
