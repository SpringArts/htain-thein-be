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
        $generalSearch = $filters['generalSearch'];
        $role = $filters['role'];
        $accountStatus = $filters['accountStatus'];

        try {
            if (!empty($generalSearch)) {
                $query->where(function ($q) use ($generalSearch) {
                    $q->where('name', 'like', '%' . $generalSearch . '%')
                        ->orWhere('email', 'like', '%' . $generalSearch . '%');
                });
            }

            if (!empty($role)) {
                $query->where('role', '=', $role);
            }

            if (!empty($accountStatus)) {
                $query->where('account_status', '=', $accountStatus);
            }


            $data = $query->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page)
                ->withQueryString();

            return $data;
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ], 422);
        }
    }
}
