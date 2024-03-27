<?php

namespace App\UseCases\Message;

use App\Models\Message;

class FetchUserMessages
{
    public function __invoke()
    {
        return Message::with('sender')->get();
    }
}
