<?php

namespace App\UseCases\Message;

use App\Events\MessageSending;
use App\Interfaces\Chat\ChatInterface;
use Illuminate\Support\Collection;

class MessageAction
{
    private ChatInterface $chatRepository;

    public function __construct(ChatInterface $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    #TODO List
    public function fetchData(): Collection
    {
        $messages = $this->chatRepository->fetchMessages();
        return $messages;
    }

    public function storeMessage(array $message): int
    {
        $message = $this->chatRepository->storeMessage($message);
        event(new MessageSending($message));
        return 200;
    }
}
