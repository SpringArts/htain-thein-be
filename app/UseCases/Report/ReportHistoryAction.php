<?php

namespace App\UseCases\Report;

use App\Models\CancelReportHistory;
use App\Models\NotiInfo;
use App\Models\Report;

class ReportHistoryAction
{
    public function createReportHistory(int $id): int
    {
        $report = Report::findOrFail($id);
        // Check if the report exists
        if (!$report) {
            return 404; // Return appropriate HTTP status code for report not found
        }

        $rejectReportData = [
            'amount' => $report->amount,
            'description' => $report->description,
            'type' => $report->type,
            'reporter_id' => $report->reporter_id,
            'rejecter_id' => auth()->user()->id,
        ];
        // Create the cancel report history entry
        CancelReportHistory::create($rejectReportData);

        $noti = NotiInfo::where('user_id', $report->reporter_id)->where('report_id', $report->id)->first();
        if ($noti) {
            $noti->update([
                'check_status' => 1
            ]);
        }

        $report->delete();

        return 201;
    }
}
