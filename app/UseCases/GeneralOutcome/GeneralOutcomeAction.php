<?php

namespace App\UseCases\GeneralOutcome;

use App\Models\GeneralOutcome;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class GeneralOutcomeAction
{
    public function fetchGeneralOutcome()
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = GeneralOutcome::orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
        return $data;
    }

    public function storeGeneralOutcome(array $data)
    {
        DB::beginTransaction();
        try {
            $outcome = GeneralOutcome::create($data);
            DB::commit();
            return $outcome;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteGeneralOutcome(GeneralOutcome $generalOutcome): int
    {
        try {
            $generalOutcome->delete();
            return 200;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function fetchMonthlyGeneralOutcome()
    {
        $monthlyTotal = GeneralOutcome::select(DB::raw('SUM(amount) as total, DATE_FORMAT(created_at, "%M") as month,DATE_FORMAT(created_at, "%Y") as year'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

        return $monthlyTotal->toArray();
    }
}
