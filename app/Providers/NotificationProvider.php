<?php

namespace App\Providers;

use App\Interfaces\Notification\NotificationInterface;
use App\Repositories\Notification\NotificationRepository;
use Illuminate\Support\ServiceProvider;

class NotificationProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            NotificationInterface::class,
            NotificationRepository::class
        );
    }
}
