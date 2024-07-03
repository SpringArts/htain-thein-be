<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\NotificationInfo\FetchAllNotificationRequest;
use App\Http\Requests\V1\App\NotificationInfo\MarkNotificationReadRequest;
use App\Http\Requests\V1\App\NotificationInfo\StoreNotiInfoRequest;
use App\Http\Resources\NotiInfoResource;
use App\Models\NotiInfo;
use App\UseCases\FireBase\FirebaseAction;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;

class NotiInfoController extends Controller
{
    private NotiInfoAction $notiInfoAction;

    private FirebaseAction $firebaseAction;

    public function __construct(NotiInfoAction $notiInfoAction, FirebaseAction $firebaseAction)
    {
        $this->notiInfoAction = $notiInfoAction;
        $this->firebaseAction = $firebaseAction;
    }

    public function index(FetchAllNotificationRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        return $this->notiInfoAction->fetchAllNotifications($formData);
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

    public function destroy(NotiInfo $notification): JsonResponse
    {
        return $this->notiInfoAction->deleteNotification($notification);
    }

    public function markAsRead(MarkNotificationReadRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        return $this->firebaseAction->markNotificationAsRead($formData);
    }
}
