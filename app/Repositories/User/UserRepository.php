<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Interfaces\User\UserInterface;

class UserRepository implements UserInterface
{
    public function getAllUsers()
    {
        return User::with('reportedReports', 'reportHistory', 'editReportHistory', 'noti', 'regularCostReport', 'verifiedReports')
            ->get();
    }

    public function getUser(int $id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser(array $userData, User $user)
    {
        return $user->update($userData);
    }

    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function userFilter(array $filters, int $limit, int $page)
    {
        $query = User::query();

        try {
            if (!empty($filters['generalSearch'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['generalSearch'] . '%')
                        ->orWhere('email', 'like', '%' . $filters['generalSearch'] . '%');
                });
            }

            if (!empty($filters['role'])) {
                $query->where('role', '=', $filters['role']);
            }

            if (!empty($filters['accountStatus'])) {
                $query->where('account_status', '=', $filters['accountStatus']);
            }

            $data = $query->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page)
                ->withQueryString();

            return $data;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
