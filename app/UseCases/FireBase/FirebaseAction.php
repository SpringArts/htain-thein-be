<?php

namespace App\UseCases\FireBase;

use App\Interfaces\Firebase\FirebaseChattingInterface;

class FirebaseAction
{
    private FirebaseChattingInterface $firebaseRepository;

    public function __construct(FirebaseChattingInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
    }

    public function storeMessage(array $data): string
    {
        $data['senderId'] = getAuthUserOrFail()->id;

        return $this->firebaseRepository->storeMessage($data);
    }

    public function markNotificationAsRead(array $formData): string
    {
        $notificationId = $formData['notificationId'];
        $userId = getAuthUserOrFail()->id;

        return $this->firebaseRepository->markNotificationAsRead($userId, $notificationId);
    }

    public function createFirebaseNotification(int $authUserId, string $type): string
    {
        return $this->firebaseRepository->storeNotification([
            'userId' => $authUserId,
            'type' => $type,
        ]);
    }
}
