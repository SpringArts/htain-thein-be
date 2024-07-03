<?php

namespace App\UseCases\GeneralOutcome;

use App\Helpers\ResponseHelper;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use App\Services\GeneralOutCome\DeleteGeneralOutComeService;
use App\Services\GeneralOutCome\FetchGeneralOutComeService;
use App\Services\GeneralOutCome\FetchMonthlyGeneralOutcomeService;
use App\Services\GeneralOutCome\StoreGeneralOutcomeService;
use App\Services\GeneralOutCome\UpdateGeneralOutComeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class GeneralOutcomeAction
{
    private GeneralOutcomeInterface $generalOutcomeRepository;

    public function __construct(GeneralOutcomeInterface $generalOutcomeRepository)
    {
        $this->generalOutcomeRepository = $generalOutcomeRepository;
    }

    public function fetchGeneralOutcome(array $validateData): JsonResponse
    {
        try {
            return (new FetchGeneralOutComeService())($this->generalOutcomeRepository, $validateData);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeGeneralOutcome(array $data): JsonResponse
    {
        try {
            return (new StoreGeneralOutcomeService())($this->generalOutcomeRepository, $data);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateGeneralOutcome(array $data, GeneralOutcome $generalOutcome): JsonResponse
    {
        try {
            return (new UpdateGeneralOutComeService())($this->generalOutcomeRepository, $data, $generalOutcome);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): JsonResponse
    {
        try {
            return (new DeleteGeneralOutComeService())($this->generalOutcomeRepository, $generalOutcome);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function fetchMonthlyGeneralOutcome(): JsonResponse
    {
        try {
            return (new FetchMonthlyGeneralOutcomeService())($this->generalOutcomeRepository);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
