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

    public function storeMessage(array $data)
    {
        $data['senderId'] = getAuthUserOrFail()->id;
        return $this->firebaseRepository->storeMessage($data);
    }
}
