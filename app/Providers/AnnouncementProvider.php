<?php

namespace App\Providers;

use App\Interfaces\Announcement\AnnouncementInterface;
use App\Repositories\Announcement\AnnouncementRepository;
use Illuminate\Support\ServiceProvider;

class AnnouncementProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            AnnouncementInterface::class,
            AnnouncementRepository::class
        );
    }
}
