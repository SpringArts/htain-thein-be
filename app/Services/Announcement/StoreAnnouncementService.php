<?php

namespace App\Services\Announcement;

use App\Helpers\ResponseHelper;
use App\Http\Resources\AnnouncementResource;
use App\Interfaces\Announcement\AnnouncementInterface;
use App\Models\Announcement;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreAnnouncementService
{
    public function __invoke(AnnouncementInterface $announcementRepository, NotiInfoAction $notificationAction, array $data): JsonResponse
    {
        try {
            $data['is_visible'] = $data['isVisible'] ?? true;
            $data['due_date'] = $data['dueDate'];
            $data['user_id'] = $this->getAuthUser();
            $announcement = $announcementRepository->createAnnouncement($data);
            $this->createNotification($notificationAction, $announcement);
            return ResponseHelper::success('Announcement created successfully', new AnnouncementResource($announcement), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function createNotification(NotiInfoAction $notificationAction, Announcement $announcement): void
    {
        $notificationAction->createNotification([
            'user_id' =>  $this->getAuthUser(),
            'announcement_id' => $announcement->id,
            'type' => 'announcement',
        ]);
    }

    private function getAuthUser(): int
    {
        return getAuthUserOrFail()->id;
    }
}
