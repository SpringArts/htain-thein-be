<?php

namespace App\Http\Controllers\Api;

use App\Models\NotiInfo;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\NotificationInfo\StoreNotiInfoRequest;
use App\Http\Requests\V1\App\NotificationInfo\UncheckNotiInfoRequest;
use App\Http\Resources\NotiInfoResource;
use App\UseCases\NotiInfo\NotiInfoAction;

class NotiInfoController extends Controller
{
    private NotiInfoAction $notiInfoAction;

    public function __construct(NotiInfoAction $notiInfoAction)
    {
        $this->notiInfoAction = $notiInfoAction;
    }

    public function index(UncheckNotiInfoRequest $request): JsonResponse
    {
        $formData = $request->safe()->all();
        $authUserId = getAuthUserOrFail()->id;
        $data = $this->notiInfoAction->fetchUncheckedNotifications($formData, $authUserId);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => NotiInfoResource::collection($data),
            'meta' => $meta,
        ]);
    }

    public function fetchAll(): JsonResponse
    {
        $data = $this->notiInfoAction->fetchAllNotifications();

        return response()->json([
            'data' => NotiInfoResource::collection($data),
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
            'data' => new NotiInfoResource($noti)
        ]);
    }

    public function update(NotiInfo $noti): JsonResponse
    {
        $this->notiInfoAction->updateNotification($noti);
        return ResponseHelper::success('Successfully Updated', null, 200);
    }

    public function destroy(NotiInfo $noti): JsonResponse
    {
        $this->notiInfoAction->deleteNotification($noti);
        return ResponseHelper::success('Successfully Deleted', null, 200);
    }
}
