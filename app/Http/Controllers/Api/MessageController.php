<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\UseCases\Message\MessageAction;

class MessageController extends Controller
{
    private MessageAction $messageAction;

    public function __construct(MessageAction $messageAction)
    {
        $this->messageAction = $messageAction;
    }

    //Message Fetching
    public function index(int $senderId = null): JsonResponse
    {
        $messages = $this->messageAction->fetchData();
        return response()->json([
            'messages' => MessageResource::collection($messages),
        ]);
    }

    //Message Storing
    public function store(Request $request): JsonResponse
    {
        try {
            $message = [
                'sender_id' => getAuthUserOrFail()->id,
                'message' => $request->message,
            ];

            $result = $this->messageAction->storeMessage($message);
            if ($result != 200) {
                return ResponseHelper::fail("Message is not sent.", null, 400, 1);
            }
            return ResponseHelper::success("Message is sent successfully.", null, 200, 0);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
