<?php

namespace App\Providers;

use App\Interfaces\Firebase\FirebaseInterface;
use App\Repositories\Firebase\FirebaseRepository;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            FirebaseInterface::class,
            FirebaseRepository::class
        );
    }
}
