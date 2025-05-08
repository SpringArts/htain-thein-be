<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\NotificationInfo\FetchAllNotificationRequest;
use App\Http\Requests\V1\App\NotificationInfo\MarkAllNotificationsRequest;
use App\Http\Requests\V1\App\NotificationInfo\StoreNotiInfoRequest;
use App\Http\Resources\NotiInfoResource;
use App\Models\NotificationRead;
use App\Models\NotiInfo;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NotiInfoController extends Controller
{
    private NotiInfoAction $notiInfoAction;

    public function __construct(NotiInfoAction $notiInfoAction)
    {
        $this->notiInfoAction = $notiInfoAction;
    }

    public function index(FetchAllNotificationRequest $request): JsonResponse
    {
        $authUserId = getAuthUserOrFail()->id;
        $validatedData = $request->safe()->all();
        return $this->notiInfoAction->getAllNotificationReadInfo($validatedData, $authUserId);
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
    public function markNotificationAsRead(NotificationRead $notificationRead): JsonResponse
    {
        $authUserId = getAuthUserOrFail()->id;

        if ($notificationRead->user_id !== $authUserId) {
            return ResponseHelper::fail('Notification is not related with your account', Response::HTTP_UNAUTHORIZED);
        }

        return $this->notiInfoAction->markNotificationAsRead($notificationRead);
    }

    public function markAllNotificationsAsRead(MarkAllNotificationsRequest $request): JsonResponse
    {
        $ids = $request->safe()->all()['ids'];
        return $this->notiInfoAction->markAllNotificationsAsRead($ids);
    }

    public function destroy(NotiInfo $notification): ?bool
    {
        return $this->notiInfoAction->deleteNotification($notification);
    }
}
