<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Announcement\BatchDeleteRequest;
use App\Http\Requests\V1\App\Announcement\FetchAnnouncementRequest;
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

    public function index(FetchAnnouncementRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->announcementAction->fetchAllAnnouncements($validatedData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->announcementAction->createAnnouncement($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement): JsonResponse
    {
        $announcement->load('announcer');

        return response()->json([
            'data' => new AnnouncementResource($announcement),
        ]);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement): JsonResponse
    {
        $formData = $request->safe()->all();
        $formData['is_visible'] = (int) $formData['isVisible'];
        return $this->announcementAction->updateAnnouncement($formData, $announcement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement): JsonResponse
    {
        Gate::authorize('adminPermission');
        return $this->announcementAction->deleteAnnouncement($announcement);
    }

    public function batchDelete(BatchDeleteRequest $request): JsonResponse
    {
        Gate::authorize('adminPermission');
        $ids = $request->safe()->all();
        return $this->announcementAction->batchDelete($ids);
    }
}
