<?php

namespace App\Services\GeneralOutCome;

use App\Helpers\ResponseHelper;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateGeneralOutComeService
{
    public function __invoke(GeneralOutcomeInterface $generalOutcomeRepository, array $data, GeneralOutcome $generalOutcome): JsonResponse
    {
        try {
            $generalOutcomeRepository->updateGeneralOutcome($data, $generalOutcome);
            return ResponseHelper::success('General Outcome updated successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
