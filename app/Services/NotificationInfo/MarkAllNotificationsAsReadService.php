<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Firebase\FirebaseInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\NotificationRead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MarkAllNotificationsAsReadService
{
    protected NotificationInterface $notiInfoRepository;
    protected FirebaseInterface $firebaseRepository;
    public function __construct(NotificationInterface $notiInfoRepository, FirebaseInterface $firebaseRepository)
    {
        $this->notiInfoRepository = $notiInfoRepository;
        $this->firebaseRepository = $firebaseRepository;
    }
    public function __invoke(array $ids): JsonResponse
    {
        $authUserId = getAuthUserOrFail()->id;
        $this->notiInfoRepository->markAsAllReadNotiInfo($ids, $authUserId);
        $getUnreadNotificationCount = $this->notiInfoRepository->getUnreadCounts($authUserId);
        $this->firebaseRepository->updateUnreadCount($authUserId, $getUnreadNotificationCount);

        return ResponseHelper::success('Notifications marked as read successfully', null, Response::HTTP_OK);
    }
}
