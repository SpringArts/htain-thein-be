<?php

namespace App\UseCases\UserAction;

use App\Helpers\ResponseHelper;
use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\DeleteUserService;
use App\Services\User\FetchUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UserAction
{
    private UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function fetchUsers(array $validatedData): JsonResponse
    {
        try {
            return (new FetchUserService())($this->userRepository, $validatedData);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(array $data): JsonResponse
    {
        try {
            return (new CreateUserService())($this->userRepository, $data);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUser(array $formData, User $user): JsonResponse
    {
        try {
            return (new UpdateUserService())($this->userRepository, $formData, $user);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUser(User $user): JsonResponse
    {
        try {
            return (new DeleteUserService())($this->userRepository, $user);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function saveLocation(Request $req): int
    {
        return 200;
    }
}
