<?php

namespace App\Interfaces\GeneralOutcome;

use App\Models\GeneralOutcome;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface GeneralOutcomeInterface
{
    public function fetchData(int $limit, int $page): LengthAwarePaginator;

    public function storeGeneralOutcome(array $formData): GeneralOutcome;

    public function updateGeneralOutcome(array $data, GeneralOutcome $generalOutcome): bool;

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): ?bool;

    public function fetchMonthlyGeneralOutcome(): Collection;
}
