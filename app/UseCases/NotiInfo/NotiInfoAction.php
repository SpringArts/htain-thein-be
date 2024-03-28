<?php

namespace App\UseCases\NotiInfo;

use App\Models\NotiInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class NotiInfoAction
{
    public function fetchAllNotifications()
    {
        $data = NotiInfo::all();
        return $data;
    }
    public function fetchNotification($userId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = NotiInfo::where('user_id', $userId)
            ->where('check_status', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($limit, ['*'], 'page', $page)
            ->appends(request()->query());
        return $data;
    }

    public function createNotificationInfo(array $data): NotiInfo
    {
        DB::beginTransaction();
        try {
            $notiInfo = NotiInfo::create($data);
            DB::commit();
            return $notiInfo;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function updateNotificationInfo(array $formData, NotiInfo $noti): int
    {
        DB::beginTransaction();
        try {
            $noti->update($formData);
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteNotificationInfo(NotiInfo $noti): int
    {
        try {
            $noti->delete();
            return 200;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
