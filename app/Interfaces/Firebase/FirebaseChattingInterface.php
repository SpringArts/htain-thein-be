<?php

namespace App\Interfaces\Firebase;

use Illuminate\Http\JsonResponse;

interface FirebaseChattingInterface
{
    public function storeMessage(array $data): JsonResponse;

    public function storeNotification(array $data): string;

    public function markNotificationAsRead(int $userId, string $notificationId): JsonResponse;
}
