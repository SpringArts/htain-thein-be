<?php

namespace App\Providers;

use App\Interfaces\Chat\ChatInterface;
use App\Repositories\Chat\ChatRepository;
use Illuminate\Support\ServiceProvider;

class ChatProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ChatInterface::class,
            ChatRepository::class
        );
    }
}
