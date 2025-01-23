<?php

namespace App\Services\User;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Interfaces\User\UserInterface;
use Illuminate\Http\JsonResponse;

class FetchUserService
{
    public function __invoke(UserInterface $userRepository, array $data): JsonResponse
    {

        $data = $userRepository->userFilter($data);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => UserResource::collection($data),
            'meta' => $meta,
        ]);
    }
}
