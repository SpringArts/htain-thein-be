<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
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
        $data = $this->notiInfoAction->fetchAllNotifications($formData);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => NotiInfoResource::collection($data),
            'meta' => $meta,
        ]);
    }

    public function store(StoreNotiInfoRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        try {
            $this->notiInfoAction->createNotification($formData);

            return ResponseHelper::success('Successfully created', null, 201);
        } catch (\Exception $e) {
            return ResponseHelper::fail($e->getMessage(), null);
        }
    }

    public function show(NotiInfo $noti): JsonResponse
    {
        return response()->json([
            'data' => new NotiInfoResource($noti),
        ]);
    }

    public function destroy(NotiInfo $noti): JsonResponse
    {
        $this->notiInfoAction->deleteNotification($noti);

        return ResponseHelper::success('Successfully Deleted', null, 200);
    }

    public function markAsRead(MarkNotificationReadRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        $this->firebaseAction->markNotificationAsRead($formData);

        return ResponseHelper::success('Successfully Marked as Read', null, 200);
    }
}
