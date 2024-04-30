<?php

namespace App\Repositories\Chat;

use App\Interfaces\Chat\ChatInterface;
use App\Models\Message;
use Illuminate\Support\Collection;

class ChatRepository implements ChatInterface
{
    public function fetchMessages(): Collection
    {
        return Message::with('sender')->get();
    }

    public function storeMessage(array $data): Message
    {
        return Message::create($data);
    }
}
