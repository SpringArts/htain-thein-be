<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Announcement\BatchDeleteRequest;
use App\Http\Requests\V1\App\Announcement\StoreAnnouncementRequest;
use App\Http\Requests\V1\App\Announcement\UpdateAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\UseCases\Announcement\AnnouncementAction;
use Gate;
use Illuminate\Http\JsonResponse;

class AnnouncementController extends Controller
{
    private AnnouncementAction $announcementAction;

    public function __construct(AnnouncementAction $announcementAction)
    {
        $this->announcementAction = $announcementAction;
    }

    public function index(): JsonResponse
    {
        $data = $this->announcementAction->fetchAllAnnouncements();

        return response()->json([
            'data' => AnnouncementResource::collection($data),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        $this->announcementAction->createAnnouncement($request->safe()->all());

        return ResponseHelper::success('Successfully created', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement): JsonResponse
    {
        return response()->json([
            'data' => new AnnouncementResource($announcement),
        ]);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): JsonResponse
    {
        $formData = $request->safe()->all();
        $formData['is_visible'] = (int) $formData['isVisible'];
        $this->announcementAction->updateAnnouncement($formData, $announcement);

        return ResponseHelper::success('Successfully Updated', null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement): JsonResponse
    {
        Gate::authorize('adminPermission');
        $this->announcementAction->deleteAnnouncement($announcement);

        return ResponseHelper::success('Successfully deleted', null, 200);
    }

    public function batchDelete(BatchDeleteRequest $request): JsonResponse
    {
        $ids = $request->safe()->all();
        $this->announcementAction->batchDelete($ids);

        return ResponseHelper::success('Successfully Deleted', null, 200);
    }
}
