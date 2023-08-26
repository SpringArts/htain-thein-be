<?php

namespace App\Http\Controllers\Api;


use App\Models\NotiInfo;
use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotiInfoRequest;
use App\Http\Resources\NotiInfoResource;
use App\UseCases\NotiInfo\NotiInfoAction;

class NotiInfoController extends Controller
{
    private $notiInfoAction;

    public function __construct(NotiInfoAction $notiInfoAction)
    {
        $this->notiInfoAction = $notiInfoAction;
    }

    public function index(): JsonResponse
    {
        $data = $this->notiInfoAction->fetchNoti(auth()->user()->id);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => NotiInfoResource::collection($data),
            'meta' => $meta,
        ]);
    }

    public function fetchAll(): JsonResponse
    {
        $data = $this->notiInfoAction->fetchAll();

        return response()->json([
            'data' => NotiInfoResource::collection($data),
        ]);
    }

    public function store(NotiInfoRequest $request): JsonResponse
    {
        $formData = $request->all();
        try {
            $this->notiInfoAction->createNotiInfo($formData);
            return ResponseHelper::success('Successfully created', null, 201);
        } catch (\Exception $e) {
            return ResponseHelper::fail($e->getMessage(), null);
        }
    }

    public function show(NotiInfo $noti): JsonResponse
    {
        return ResponseHelper::success('success', new NotiInfoResource($noti));
    }

    public function update(NotiInfoRequest $request, NotiInfo $noti): JsonResponse
    {
        try {
            $this->notiInfoAction->updateNotiInfo($request, $noti);
            return ResponseHelper::success('Successfully Updated', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::fail($e->getMessage(), null);
        }
    }

    public function destroy(NotiInfo $noti): JsonResponse
    {
        try {
            $this->notiInfoAction->deleteNotiInfo($noti);
            return ResponseHelper::success('Successfully Deleted', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::fail($e->getMessage(), null);
        }
    }
}
