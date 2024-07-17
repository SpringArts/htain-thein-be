<?php

namespace App\UseCases\GeneralOutcome;

use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use App\Services\GeneralOutCome\DeleteGeneralOutComeService;
use App\Services\GeneralOutCome\FetchGeneralOutComeService;
use App\Services\GeneralOutCome\FetchMonthlyGeneralOutcomeService;
use App\Services\GeneralOutCome\StoreGeneralOutcomeService;
use App\Services\GeneralOutCome\UpdateGeneralOutComeService;
use Illuminate\Http\JsonResponse;

class GeneralOutcomeAction
{
    private GeneralOutcomeInterface $generalOutcomeRepository;

    public function __construct(GeneralOutcomeInterface $generalOutcomeRepository)
    {
        $this->generalOutcomeRepository = $generalOutcomeRepository;
    }

    public function fetchGeneralOutcome(array $validateData): JsonResponse
    {
        return (new FetchGeneralOutComeService())($this->generalOutcomeRepository, $validateData);
    }

    public function storeGeneralOutcome(array $data): JsonResponse
    {
        return (new StoreGeneralOutcomeService())($this->generalOutcomeRepository, $data);
    }

    public function updateGeneralOutcome(array $data, GeneralOutcome $generalOutcome): JsonResponse
    {
        return (new UpdateGeneralOutComeService())($this->generalOutcomeRepository, $data, $generalOutcome);
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): JsonResponse
    {
        return (new DeleteGeneralOutComeService())($this->generalOutcomeRepository, $generalOutcome);
    }

    public function fetchMonthlyGeneralOutcome(): JsonResponse
    {
        return (new FetchMonthlyGeneralOutcomeService())($this->generalOutcomeRepository);
    }
}
