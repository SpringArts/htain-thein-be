<?php

namespace App\UseCases\UserAction;

use App\Interfaces\User\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAction
{
    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchUsers(array $validatedData): LengthAwarePaginator
    {
        return $this->userRepository->userFilter($validatedData);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function updateUser(array $formData, User $user): bool
    {
        $userData = $formData;

        if (isset($formData['password'])) {
            $userData['password'] = Hash::make($formData['password']);
        }

        return $this->userRepository->updateUser($userData, $user);
    }

    public function deleteUser(User $user): bool|null
    {
        return $this->userRepository->deleteUser($user);
    }

    public function saveLocation(Request $req): int
    {
        return 200;
        // DB::beginTransaction();
        // try {
        //     $saveLocation = new UserLocation();
        //     $saveLocation->latitude = $req->latitude;
        //     $saveLocation->longitude = $req->longitude;
        //     $saveLocation->save();
        //     DB::commit();
        //     return 200;
        // } catch (QueryException $e) {
        //     DB::rollBack();
        //     throw new \Exception($e->getMessage());
        // }
    }
}
