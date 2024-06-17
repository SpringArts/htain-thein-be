<?php

namespace App\Repositories\Report;

use App\Interfaces\Report\ReportHistoryInterface;
use App\Models\CancelReportHistory;
use App\Models\ReportEditHistory;
use Illuminate\Support\Collection;

class ReportHistoryRepository implements ReportHistoryInterface
{
    public function getAllReportChangedHistories(): Collection
    {
        return ReportEditHistory::with('report', 'editUser')->get();
    }

    public function getReportChangedHistory(int $reportId): Collection
    {
        return ReportEditHistory::where('report_id', $reportId)->get();
    }

    public function createReportChangedHistory(int $id): ReportEditHistory
    {
        return ReportEditHistory::create([
            'report_id' => $id,
            'user_id' => getAuthUserOrFail()->id,
        ]);
    }

    public function rejectReportHistory(array $rejectReportData): void
    {
        CancelReportHistory::create($rejectReportData);
    }
}
