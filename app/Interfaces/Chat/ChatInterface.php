<?php

namespace App\Interfaces\Chat;

use App\Models\Message;
use Illuminate\Support\Collection;

interface ChatInterface
{
    public function fetchMessages(): Collection;
    public function storeMessage(array $data): Message;
}
