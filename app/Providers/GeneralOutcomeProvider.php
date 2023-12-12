<?php

namespace App\Providers;

use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Repositories\GeneralOutcome\GeneralOutcomeRepository;
use Illuminate\Support\ServiceProvider;

class GeneralOutcomeProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            GeneralOutcomeInterface::class,
            GeneralOutcomeRepository::class
        );
    }
}
