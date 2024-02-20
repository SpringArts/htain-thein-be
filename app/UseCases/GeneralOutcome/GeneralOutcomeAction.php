<?php

namespace App\UseCases\GeneralOutcome;

use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use Illuminate\Database\Eloquent\Collection;

class GeneralOutcomeAction
{
    private GeneralOutcomeInterface $generalOutcomeRepository;

    public function __construct(GeneralOutcomeInterface $generalOutcomeRepository)
    {
        $this->generalOutcomeRepository = $generalOutcomeRepository;
    }

    public function fetchGeneralOutcome()
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = $this->generalOutcomeRepository->fetchData($limit, $page);
        return $data;
    }

    public function storeGeneralOutcome(array $data): GeneralOutcome
    {
        return $this->generalOutcomeRepository->storeGeneralOutcome($data);
    }

    public function updateGeneralOutcome(array $data, GeneralOutcome $generalOutcome): int
    {
        return $this->generalOutcomeRepository->updateGeneralOutcome($data, $generalOutcome);
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): int
    {
        return $this->generalOutcomeRepository->deleteGeneralOutcome($generalOutcome);
    }

    public function fetchMonthlyGeneralOutcome(): Collection
    {
        return $this->generalOutcomeRepository->fetchMonthlyGeneralOutcome();
    }
}
