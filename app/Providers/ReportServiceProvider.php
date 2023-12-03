<?php

namespace App\Providers;

use App\Interfaces\ReportInterface;
use App\Repositories\ReportRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\NotificationInterface;
use App\Repositories\NotificationRepository;
use App\Interfaces\ReportEditHistoryInterface;
use App\Repositories\ReportEditHistoryRepository;

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
