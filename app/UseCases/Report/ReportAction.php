<?php

namespace App\UseCases\Report;

use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Models\NotiInfo;
use App\Models\ReportEditHistory;
use App\Services\FinancialCalculatorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;

class ReportAction
{
    public function fetchData(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = Report::where('verifier_id', '!=', '')
            ->where('confirm_status', 1)
            ->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
        return $data;
    }

    public function createReport(array $data): Report
    {
        if ($data['type'] == "Outcome") {
            if (FinancialCalculatorService::calculateAvailableBalance() < $data['amount']) {
                throw new \Exception(FinancialCalculatorService::calculateAvailableBalance() . ' kyat is only available.');
            }
        }
        DB::beginTransaction();
        try {
            $report = Report::create($data);
            DB::commit();
            return $report;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function updateReport(ReportRequest $request, Report $report): int
    {
        DB::beginTransaction();
        try {
            $oldData = $report->toArray();
            $report->update($request->all());
            $newData = $report->toArray();
            $this->editHistory($oldData, $newData);
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function uncheckReport(): Collection
    {
        $data = Report::where('confirm_status', 0)->get();
        return $data;
    }

    public function acceptReport(Report $report): int
    {
        DB::beginTransaction();
        try {
            $report->update([
                'verifier_id' => auth()->user()->id,
                'confirm_status' => 1
            ]);

            $noti = NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->first();
            if ($noti) {
                $noti->update([
                    'check_status' => 1
                ]);
            }
            DB::commit();
            return 200;
        } catch (QueryException $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function calculationFinancial(): array
    {
        $overviewData = FinancialCalculatorService::overviewCalculate();
        return $overviewData;
    }
    public function deleteReport(Report $report): int
    {
        try {
            $report->delete();
            return 200;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    protected function editHistory(array $oldData, array $newData): void
    {
        $history = new ReportEditHistory();
        $history->editor_id = Auth::id();
        $history->report_id = $oldData['id'];

        $oldDataChangeFields = [];
        $newDataChangeFields = [];

        foreach ($newData as $key => $value) {
            if (isset($oldData[$key]) && $oldData[$key] !== $value) {
                $oldDataChangeFields[$key] = $oldData[$key];
                $newDataChangeFields[$key] = $value;
            }
        }
        if (!empty($newDataChangeFields)) {
            $history->old_data = json_encode($oldDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            $history->new_data = json_encode($newDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            $history->save();
        }
    }

    public function fetchChangedHistory()
    {
        $histories = ReportEditHistory::all();
        return $histories;
    }
}
