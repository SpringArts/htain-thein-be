<?php

namespace App\Providers;

use App\Interfaces\Auth\UserAgentInterface;
use App\Repositories\Auth\UserAgentRepository;
use Illuminate\Support\ServiceProvider;

class UserAgentProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(
            UserAgentInterface::class,
            UserAgentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
