<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Interfaces\User\UserInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserInterface
{
    public function getAllUsers(): Collection
    {
        return User::with('reportedReports', 'reportHistories', 'editReportHistories', 'noti', 'regularCostReport', 'verifiedReports')
            ->get();
    }

    public function getUser(int $id): User
    {
        return User::findOrFail($id);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(array $userData, User $user): bool
    {
        return $user->update($userData);
    }

    public function deleteUser(User $user): bool|null
    {
        return $user->delete();
    }

    public function userFilter(array $validatedData): LengthAwarePaginator
    {
        $query = User::query();
        $limit = $validatedData['limit'] ?? 8;
        $page = $validatedData['page'] ?? 1;
        $generalSearch = $validatedData['generalSearch'] ?? null;
        $role = $validatedData['role'] ?? null;
        $accountStatus = $validatedData['accountStatus'] ?? null;
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
    }
}
