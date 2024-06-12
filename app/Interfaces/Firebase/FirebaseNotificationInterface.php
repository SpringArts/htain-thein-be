<?php

namespace App\Interfaces\Firebase;

use Illuminate\Http\JsonResponse;

interface FirebaseNotificationInterface
{
    public function storeMessage(array $data): JsonResponse;
}
