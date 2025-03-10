<?php

namespace App\Repositories\Firebase;

use App\Interfaces\Firebase\FirebaseInterface;
use App\Services\Firebase\FirebaseConnectionService;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Http\JsonResponse;

class FirebaseRepository implements FirebaseInterface
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
            'senderName' => $data['senderName'],
            'timestamp' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['message' => 'Message sent successfully']);
    }

    /**
     * Update unread count in FireStore for a single user
     */
    public function updateUnreadCount(int $userId, int $unreadCount): void
    {
        $userMetaRef = $this->fireStore->collection('users')
            ->document($userId);

        $userMetaRef->set([
            'unread_count' => $unreadCount,
            'last_updated' => new Timestamp(new \DateTime())
        ], ['merge' => true]);
    }

    /**
     * Batch update unread count for all users
     */
    public function batchUpdateUnreadCounts(array $userUnreadCounts): void
    {
        $batch = $this->fireStore->batch();

        foreach ($userUnreadCounts as $userId => $unreadCount) {
            $userMetaRef = $this->fireStore->collection('users')
                ->document($userId);

            $batch->set($userMetaRef, [
                'unread_count' => $unreadCount,
                'last_updated' => new Timestamp(new \DateTime())
            ], ['merge' => true]);
        }

        $batch->commit();
    }
}
