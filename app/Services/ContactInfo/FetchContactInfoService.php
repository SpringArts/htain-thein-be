<?php

namespace App\Services\ContactInfo;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ContactInfoResource;
use App\Interfaces\ContactInfo\ContactInfoInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchContactInfoService
{
    public function __invoke(ContactInfoInterface $contactInfoRepository, array $data): JsonResponse
    {
        try {
            $limit = $data['limit'] ?? 8;
            $page = $data['page'] ?? 1;
            $data = $contactInfoRepository->fetchData($limit, $page);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => ContactInfoResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
