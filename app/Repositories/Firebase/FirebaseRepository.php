<?php

namespace App\Repositories\Firebase;

use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Services\Firebase\FirebaseConnectionService;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\JsonResponse;

class FirebaseRepository implements FirebaseChattingInterface
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
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        return response()->json(['message' => 'Message sent successfully']);
    }
}
