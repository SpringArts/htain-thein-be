<?php

namespace App\Repositories\Firebase;

use App\Interfaces\Firebase\FirebaseNotificationInterface;
use App\Services\Firebase\FirebaseConnectionService;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\JsonResponse;

class FirebaseRepository implements FirebaseNotificationInterface
{
    protected FirestoreClient $fireStore;

    public function __construct()
    {
        $this->fireStore = FirebaseConnectionService::getConnection();
    }

    public function storeMessage(array $data): JsonResponse
    {
        $this->fireStore->collection('messages')->add([
            'senderId' => $data['senderId'],
            'message' => $data['message'],
            'timestamp' => now(),
        ]);

        return response()->json(['message' => 'Message sent successfully']);
    }
}
