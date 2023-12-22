<?php


namespace App\UseCases\Message;


use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FetchConnectedUserAction
{
    public function __invoke(int $senderId)
    {
        DB::statement("SET SESSION sql_mode=''");

        $recentUsers = Message::where(function ($query) use ($senderId) {
            $query->where('sender_id', $senderId)
                ->orWhere('receiver_id', $senderId);
        })
            ->groupBy('sender_id', 'receiver_id')
            ->select('sender_id', 'receiver_id', 'message')
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get();

        $recentUsersWithMessage = [];
        $usedUserIds = [];

        foreach ($recentUsers as $message) {
            $userId = $message->sender_id == $senderId ? $message->receiver_id : $message->sender_id;
            if (!in_array($userId, $usedUserIds)) {
                $recentUsersWithMessage[] = [
                    'user_id' => $userId,
                    'message' => $message->message,
                ];
                $usedUserIds[] = $userId;
            }
        }

        foreach ($recentUsersWithMessage as $key => $userMessage) {
            $recentUsersWithMessage[$key]['name'] = User::where('id', $userMessage['user_id'])->value('name') ?? '';
        }

        return $recentUsersWithMessage;
    }
}
