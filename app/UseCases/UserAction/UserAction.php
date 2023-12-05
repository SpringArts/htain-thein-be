<?php

namespace App\UseCases\UserAction;

use App\Http\Requests\UserRequest;
use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAction
{
    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchUsers(): LengthAwarePaginator
    {
        $limit = request()->limit ?? 6;
        $page = request()->page ?? 1;
        $filters = [
            'generalSearch' => request()->generalSearch,
            'role' => request()->role,
            'accountStatus' => request()->accountStatus,
        ];

        return $this->userRepository->userFilter($filters, $limit, $page);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function updateUser(UserRequest $request, User $user): int
    {
        $userData = $request->except(['password']);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        return $this->userRepository->updateUser($userData, $user);
    }

    public function deleteUser(User $user): int
    {
        return $this->userRepository->deleteUser($user);
    }

    public function saveLocation(Request $req): int
    {
        DB::beginTransaction();
        try {
            $saveLocation = new UserLocation();
            $saveLocation->latitude = $req->latitude;
            $saveLocation->longitude = $req->longitude;
            $saveLocation->save();
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function searchUser(string $searchUser): User
    {
        $result = User::where();

        return $result;
    }
}
