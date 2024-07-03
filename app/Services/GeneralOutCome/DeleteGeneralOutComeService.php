<?php

namespace App\Services\GeneralOutCome;

use App\Helpers\ResponseHelper;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteGeneralOutComeService
{
    public function __invoke(GeneralOutcomeInterface $generalOutcomeRepository, GeneralOutcome $generalOutcome): JsonResponse
    {
        try {
            $generalOutcomeRepository->deleteGeneralOutcome($generalOutcome);
            return ResponseHelper::success('General Outcome deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
