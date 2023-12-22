<?php


namespace App\UseCases\Message;


use App\Models\Message;

class StoreMessageAction
{

    public function __invoke(array $data): Message
    {
        return Message::create($data);
    }
}
