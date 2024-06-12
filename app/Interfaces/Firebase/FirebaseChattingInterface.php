<?php

namespace App\Interfaces\Firebase;

use Illuminate\Http\JsonResponse;

interface FirebaseChattingInterface
{
    public function storeMessage(array $data): JsonResponse;
}
