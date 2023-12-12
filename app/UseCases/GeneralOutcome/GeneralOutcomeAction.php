<?php

namespace App\UseCases\GeneralOutcome;

use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


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

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): int
    {
        return $this->generalOutcomeRepository->deleteGeneralOutcome($generalOutcome);
    }

    public function fetchMonthlyGeneralOutcome(): Collection
    {
        return $this->generalOutcomeRepository->fetchMonthlyGeneralOutcome();
    }
}
