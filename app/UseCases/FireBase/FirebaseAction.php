<?php

namespace App\UseCases\FireBase;

use App\Interfaces\Firebase\FirebaseInterface;
use Illuminate\Http\JsonResponse;

class FirebaseAction
{
    private FirebaseInterface $firebaseRepository;

    public function __construct(FirebaseInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
    }

    public function storeMessage(array $data): JsonResponse
    {
        $data['senderId'] = getAuthUserOrFail()->id;

        return $this->firebaseRepository->storeMessage($data);
    }

    public function markNotificationAsRead(array $formData): JsonResponse
    {
        $notificationId = $formData['notificationId'];
        $userId = getAuthUserOrFail()->id;

        return $this->firebaseRepository->markNotificationAsRead($userId, $notificationId);
    }
}
