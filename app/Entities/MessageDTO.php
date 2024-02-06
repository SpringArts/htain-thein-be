<?php

namespace App\Entities;

class MessageDTO
{
    public int $sender_id;
    public string $message;

    public function __construct(int $sender_id, string $message)
    {
        $this->sender_id = $sender_id;
        $this->message = $message;
    }
}
