<?php

namespace App\Repositories;

use App\Models\ReportEditHistory;
use App\Interfaces\ReportEditHistoryInterface;

class ReportEditHistoryRepository implements ReportEditHistoryInterface
{
    public function getAllReportChangedHistories()
    {
        return ReportEditHistory::all();
    }
}
