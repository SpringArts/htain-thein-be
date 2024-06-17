<?php

namespace App\Providers;

use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Interfaces\Report\ReportInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Report\ReportHistoryRepository;
use App\Repositories\Report\ReportRepository;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ReportInterface::class,
            ReportRepository::class
        );

        $this->app->bind(
            ReportHistoryInterface::class,
            ReportHistoryRepository::class
        );

        $this->app->bind(
            NotificationInterface::class,
            NotificationRepository::class
        );
    }
}
