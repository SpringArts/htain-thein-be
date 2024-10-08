<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Firebase\StoreMessageRequest;
use App\UseCases\FireBase\FirebaseAction;
use Illuminate\Http\JsonResponse;

class FirebaseChattingController extends Controller
{
    private FirebaseAction $firebaseAction;

    public function __construct(FirebaseAction $firebaseAction)
    {
        $this->firebaseAction = $firebaseAction;
    }

    public function sendMessage(StoreMessageRequest $request): JsonResponse
    {
        $data = $request->safe()->all();

        return $this->firebaseAction->storeMessage($data);
    }
}
