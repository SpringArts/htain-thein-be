<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Chat\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\UseCases\Message\MessageAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    private MessageAction $messageAction;

    public function __construct(MessageAction $messageAction)
    {
        $this->messageAction = $messageAction;
    }

    //Message Fetching
    public function index(?int $senderId = null): JsonResponse
    {
        $messages = $this->messageAction->fetchData();

        return response()->json([
            'messages' => MessageResource::collection($messages),
        ]);
    }

    //Message Storing
    public function store(StoreMessageRequest $request): JsonResponse
    {
        try {
            $message = [
                'sender_id' => getAuthUserOrFail()->id,
                'message' => $request->message,
            ];

            $result = $this->messageAction->storeMessage($message);
            if ($result != 200) {
                return ResponseHelper::fail('Message is not sent.', null, 400, 1);
            }

            return ResponseHelper::success('Message is sent successfully.', null, 200, 0);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
