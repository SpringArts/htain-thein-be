<?php

namespace App\Interfaces\Firebase;

use Illuminate\Http\JsonResponse;

interface FirebaseInterface
{
    public function storeMessage(array $data): JsonResponse;

    public function updateUnreadCount(int $userId, int $unreadCount): void;

    public function batchUpdateUnreadCounts(array $userUnreadCounts): void;
}
