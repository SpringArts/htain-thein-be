<?php


namespace App\Repositories\GeneralOutcome;

use App\Models\GeneralOutcome;
use Illuminate\Support\Facades\DB;
use App\Interfaces\GeneralOutcome\GeneralOutcomeInterface;
use Illuminate\Database\Eloquent\Collection;

class GeneralOutcomeRepository implements GeneralOutcomeInterface
{
    public function fetchData(int $limit, int $page)
    {
        return GeneralOutcome::with('reporter')->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function storeGeneralOutcome(array $formData): GeneralOutcome
    {
        return GeneralOutcome::create($formData);
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): int
    {
        return  $generalOutcome->delete();
    }

    public function fetchMonthlyGeneralOutcome(): Collection
    {
        return GeneralOutcome::select(DB::raw('SUM(amount) as total, DATE_FORMAT(created_at, "%M") as month,DATE_FORMAT(created_at, "%Y") as year'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
    }
}
