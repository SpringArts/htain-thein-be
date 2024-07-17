<?php

namespace App\UseCases\UserAction;

use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\FetchUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAction
{
    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchUsers(array $validatedData): JsonResponse
    {
        return (new FetchUserService())($this->userRepository, $validatedData);
    }

    public function createUser(array $data): JsonResponse
    {
        return (new CreateUserService())($this->userRepository, $data);
    }

    public function updateUser(array $formData, User $user): JsonResponse
    {
        return (new UpdateUserService())($this->userRepository, $formData, $user);
    }

    public function deleteUser(User $user): JsonResponse
    {
        return (new DeleteUserService())($this->userRepository, $user);
    }

    public function saveLocation(Request $req): int
    {
        return 200;
    }
}
