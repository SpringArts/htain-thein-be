<?php

namespace App\Services\User;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Interfaces\User\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchUserService
{
    public function __invoke(UserInterface $userRepository, array $data): JsonResponse
    {
        try {
            $data = $userRepository->userFilter($data);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => UserResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
