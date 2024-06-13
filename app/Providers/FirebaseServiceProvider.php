<?php

namespace App\Providers;

use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Repositories\Firebase\FirebaseRepository;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            FirebaseChattingInterface::class,
            FirebaseRepository::class
        );
    }
}
