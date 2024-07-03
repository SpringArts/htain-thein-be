<?php

namespace App\Services\GeneralOutCome;

use App\Helpers\ResponseHelper;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchMonthlyGeneralOutcomeService
{
    public function __invoke(GeneralOutcomeInterface $generalOutcomeRepository): JsonResponse
    {
        try {
            $data = $generalOutcomeRepository->fetchMonthlyGeneralOutcome();
            return response()->json([
                'data' => $data,
            ],);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
