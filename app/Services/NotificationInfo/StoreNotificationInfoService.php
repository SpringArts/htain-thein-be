<?php

namespace App\Services\NotificationInfo;

use App\Helpers\ResponseHelper;
use App\Interfaces\Firebase\FirebaseInterface;
use App\Interfaces\Notification\NotificationInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class StoreNotificationInfoService
{
    protected $notiInfoRepository;
    protected $firebaseRepository;

    public function __construct(NotificationInterface $notiInfoRepository, FirebaseInterface $firebaseRepository)
    {
        $this->notiInfoRepository = $notiInfoRepository;
        $this->firebaseRepository = $firebaseRepository;
    }

    public function __invoke(array $formData): JsonResponse
    {
        $this->createNotification($formData);
        $this->updateFireStoreUnreadCounts();

        return ResponseHelper::success('Notification created successfully', null, Response::HTTP_CREATED);
    }

    private function createNotification(array $formData): void
    {
        $this->notiInfoRepository->createNotification(
            $formData['user_id'],
            $formData['report_id'] ?? null,
            $formData['announcement_id'] ?? null
        );
    }

    private function updateFireStoreUnreadCounts(): void
    {
        $users = $this->fetchAllUsers();
        $userUnreadCounts = $this->getUserUnreadCounts($users);
        $this->firebaseRepository->batchUpdateUnreadCounts($userUnreadCounts);
    }

    private function fetchAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * Get unread counts for all users from laravel database
     */
    private function getUserUnreadCounts(Collection $users): array
    {
        $userUnreadCounts = [];

        foreach ($users as $user) {
            $userUnreadCounts[$user->id] = $this->notiInfoRepository->getUnreadCounts($user->id);
        }

        return $userUnreadCounts;
    }
}
