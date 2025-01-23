<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\NotificationInfo\FetchAllNotificationRequest;
use App\Http\Requests\V1\App\NotificationInfo\StoreNotiInfoRequest;
use App\Http\Resources\NotiInfoResource;
use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotiInfoController extends Controller
{
    private NotiInfoAction $notiInfoAction;

    // private FirebaseAction $firebaseAction;

    public function __construct(NotiInfoAction $notiInfoAction)
    {
        $this->notiInfoAction = $notiInfoAction;
        //   $this->firebaseAction = $firebaseAction;
    }

    public function index(FetchAllNotificationRequest $request): JsonResponse
    {
        $authUserId = $this->getAuthUserId();
        $validatedData = $request->safe()->all();
        return $this->notiInfoAction->getAllNotifications($validatedData, $authUserId);
    }


    public function store(StoreNotiInfoRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();

        return $this->notiInfoAction->createNotification($formData);
    }

    public function show(NotiInfo $notification): JsonResponse
    {
        $notification->load('report', 'user', 'announcement');

        return response()->json([
            'data' => new NotiInfoResource($notification),
        ]);
    }

    public function destroy(NotiInfo $notification): ?bool
    {
        return $this->notiInfoAction->deleteNotification($notification);
    }

    // Firebase Functions
    // public function markAsRead(Request $request): JsonResponse
    // {
    //     $formData = $request->safe()->all();
    //     return $this->firebaseAction->markNotificationAsRead($formData);
    // }



    public function markNotificationAsRead(NotificationRead $notificationRead): JsonResponse
    {
        $authUserId = $this->getAuthUserId();

        if ($notificationRead->user_id !== $authUserId) {
            return ResponseHelper::fail('Notification is not related with your account', Response::HTTP_UNAUTHORIZED);
        }

        return $this->notiInfoAction->markNotificationAsRead($notificationRead);
    }

    private function getAuthUserId(): int
    {
        return getAuthUserOrFail()->id;
    }
}
