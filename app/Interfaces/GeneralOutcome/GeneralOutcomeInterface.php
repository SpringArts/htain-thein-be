<?php

namespace App\Interfaces\GeneralOutcome;

use App\Models\GeneralOutcome;
use Illuminate\Database\Eloquent\Collection;

interface GeneralOutcomeInterface
{
    public function fetchData(int $limit, int $page);
    public function storeGeneralOutcome(array $formData): GeneralOutcome;
    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): int;
    public function fetchMonthlyGeneralOutcome(): Collection;
}
