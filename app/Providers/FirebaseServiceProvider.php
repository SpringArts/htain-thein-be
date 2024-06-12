<?php

namespace App\Providers;

use App\Interfaces\Firebase\FirebaseNotificationInterface;
use App\Repositories\Firebase\FirebaseRepository;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            FirebaseNotificationInterface::class,
            FirebaseRepository::class
        );
    }
}
