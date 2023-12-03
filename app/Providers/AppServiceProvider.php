<?php

namespace App\Providers;

use App\Interfaces\NotificationInterface;
use App\Interfaces\ReportEditHistoryInterface;
use App\Interfaces\ReportInterface;
use App\Repositories\ReportRepository;
use App\UseCases\Report\ReportAction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
