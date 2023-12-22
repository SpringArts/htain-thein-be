<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Report\ReportInterface;
use App\Repositories\Report\ReportRepository;
use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Report\ReportHistoryRepository;

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
