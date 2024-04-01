<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\UseCases\Announcement\AnnouncementAction;

class AnnouncementController extends Controller
{
    private $announcementAction;


    public function __construct(AnnouncementAction $announcementAction)
    {
        $this->announcementAction = $announcementAction;
    }

    public function index()
    {
        $data = $this->announcementAction->fetchAllAnnouncements();
        return response()->json([
            'data' => AnnouncementResource::collection($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        return $this->announcementAction->createAnnouncement($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        return new AnnouncementResource($announcement);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        return $this->announcementAction->deleteAnnouncement($announcement);
    }
}
