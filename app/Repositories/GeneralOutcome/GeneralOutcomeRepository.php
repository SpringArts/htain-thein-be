<?php

namespace App\Repositories\GeneralOutcome;

use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use App\Models\GeneralOutcome;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GeneralOutcomeRepository implements GeneralOutcomeInterface
{
    public function fetchData(int $limit, int $page): LengthAwarePaginator
    {
        return GeneralOutcome::with('reporter')->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function storeGeneralOutcome(array $formData): GeneralOutcome
    {
        return GeneralOutcome::create($formData);
    }

    public function updateGeneralOutcome(array $data, GeneralOutcome $generalOutcome): bool
    {
        return $generalOutcome->update($data);
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): ?bool
    {
        return $generalOutcome->delete();
    }

    public function fetchMonthlyGeneralOutcome(): Collection
    {
        return GeneralOutcome::select(DB::raw('SUM(amount) as total, DATE_FORMAT(created_at, "%M") as month,DATE_FORMAT(created_at, "%Y") as year'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
    }
}
