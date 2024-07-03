<?php

namespace App\Services\User;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Interfaces\User\UserInterface;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateUserService
{
    public function __invoke(UserInterface $userRepository, array $data): JsonResponse
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $user = $userRepository->createUser($data);
            return ResponseHelper::success('User created successfully', new UserResource($user), Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
