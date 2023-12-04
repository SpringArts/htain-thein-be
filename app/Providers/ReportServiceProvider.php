<?php

namespace App\Providers;

use App\Interfaces\ReportInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\NotificationInterface;
use App\Repositories\Report\ReportRepository;
use App\Interfaces\ReportEditHistoryInterface;
use App\Repositories\Report\ReportEditHistoryRepository;
use App\Repositories\Notification\NotificationRepository;

class ReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ReportInterface::class,
            ReportRepository::class
        );

        $this->app->bind(
            ReportEditHistoryInterface::class,
            ReportEditHistoryRepository::class
        );

        $this->app->bind(
            NotificationInterface::class,
            NotificationRepository::class
        );
    }
}
