<?php

namespace App\Services\User;

use App\Helpers\ResponseHelper;
use App\Interfaces\User\UserInterface;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateUserService
{
    public function __invoke(UserInterface $userRepository, array $formData, User $user): JsonResponse
    {
        try {
            if (isset($formData['password'])) {
                $formData['password'] = Hash::make($formData['password']);
            }
            $userRepository->updateUser($formData, $user);

            return ResponseHelper::success('User updated successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
