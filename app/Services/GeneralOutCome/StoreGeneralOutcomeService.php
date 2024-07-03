<?php

namespace App\Services\GeneralOutCome;

use App\Helpers\ResponseHelper;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StoreGeneralOutcomeService
{
    public function __invoke(GeneralOutcomeInterface $generalOutcomeRepository, array $data): JsonResponse
    {
        try {
            $generalOutcomeRepository->storeGeneralOutcome($data);
            return ResponseHelper::success('General Outcome created successfully', null, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
