<?php

namespace App\Services\GeneralOutCome;

use App\Helpers\ResponseHelper;
use App\Http\Resources\GeneralOutcomeResource;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchGeneralOutComeService
{
    public function __invoke(GeneralOutcomeInterface $generalOutcomeRepository, array $data): JsonResponse
    {
        try {
            $limit = $data['limit'] ?? 8;
            $page = $data['page'] ?? 1;
            $data = $generalOutcomeRepository->fetchData($limit, $page);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => GeneralOutcomeResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
