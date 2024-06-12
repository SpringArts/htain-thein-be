<?php

namespace App\UseCases\FireBase;

use App\Interfaces\Firebase\FirebaseNotificationInterface;

class FirebaseAction
{
    private FirebaseNotificationInterface $firebaseRepository;

    public function __construct(FirebaseNotificationInterface $firebaseRepository)
    {
        $this->firebaseRepository = $firebaseRepository;
    }

    public function storeMessage(array $data)
    {
        $data['senderId'] = getAuthUserOrFail()->id;
        return $this->firebaseRepository->storeMessage($data);
    }
}
