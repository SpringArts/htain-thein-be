<?php

namespace App\Repositories\Firebase;

use App\Interfaces\Firebase\FirebaseChattingInterface;
use App\Services\Firebase\FirebaseConnectionService;
use Google\Cloud\Firestore\FieldValue;
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
            'timestamp' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['message' => 'Message sent successfully']);
    }

    public function storeNotification(array $data): string
    {
        $notifications = $this->fireStore->collection('notifications')->add([
            'userId' => $data['user_id'],
            'type' => $data['type'],
            'timestamp' => date('Y-m-d H:i:s'),
        ]);
        $notificationId = $notifications->id();

        return $notificationId;
    }

    public function markNotificationAsRead(int $userId, string $notificationId): JsonResponse
    {
        $notificationReadsRef = $this->fireStore->collection('notification_reads')->document($notificationId);
        $notificationReadsRef->set([
            'userIds' => FieldValue::arrayUnion([$userId]),
        ], ['merge' => true]);

        return response()->json(['message' => 'Notification marked as read successfully']);
    }
}
