<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Events\MessageSending;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Auth;
use App\UseCases\Message\FetchUserMessages;
use App\UseCases\Message\StoreMessageAction;

class MessageController extends Controller
{
    //Message Fetching
    public function index(int $senderId = null): JsonResponse
    {
        $messages = empty($senderId) ? [] : (new FetchUserMessages())();

        return response()->json([
            'messages' => MessageResource::collection($messages),
        ]);
    }

    //Message Storing
    public function store(Request $request): JsonResponse
    {
        try {
            $message = (new StoreMessageAction())([
                'sender_id' => Auth::user()->id,
                'message' => $request->message,
            ]);

            event(new MessageSending($message));
            return ResponseHelper::success("Message is sent successfully.", null, 200, 0);
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }
}
