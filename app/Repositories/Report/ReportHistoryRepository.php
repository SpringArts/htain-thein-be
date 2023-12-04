<?php

namespace App\Repositories\Report;

use App\Models\ReportEditHistory;
use App\Models\CancelReportHistory;
use App\Interfaces\Report\ReportHistoryInterface;

class ReportHistoryRepository implements ReportHistoryInterface
{
    public function getAllReportChangedHistories()
    {
        return ReportEditHistory::all();
    }

    public function getReportChangedHistory(int $id)
    {
        return ReportEditHistory::where('report_id', $id)->get();
    }

    public function createReportChangedHistory(int $id)
    {
        return ReportEditHistory::create([
            'report_id' => $id,
            'user_id' => auth()->user()->id
        ]);
    }

    public function rejectReportHistory(array $rejectReportData)
    {
        CancelReportHistory::create($rejectReportData);
    }
}
