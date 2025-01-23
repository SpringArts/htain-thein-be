<?php

namespace App\Services\User;

use App\Enums\AccountType;
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
        // Only update password if it's provided and not empty
        if (isset($formData['password']) && ! empty($formData['password'])) {
            $formData['password'] = Hash::make($formData['password']);
        } else {
            unset($formData['password']); // Remove password from update data if not provided
        }

        $userRepository->updateUser($formData, $user);

        if ($user->account_status == AccountType::SUSPENDED) {
            $user->tokens()->delete();
        }

        return ResponseHelper::success('User updated successfully', null, Response::HTTP_OK);
    }
}
