<?php

namespace App\Providers;

use App\Interfaces\ContactInfo\ContactInfoInterface;
use App\Repositories\ContactInfo\ContactInfoRepository;
use Illuminate\Support\ServiceProvider;

class ContactProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ContactInfoInterface::class,
            ContactInfoRepository::class
        );
    }
}
