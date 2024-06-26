<?php

namespace App\Interfaces\Report;

use App\Models\ReportEditHistory;
use Illuminate\Support\Collection;

interface ReportHistoryInterface
{
    public function getAllReportChangedHistories(): Collection;

    public function getReportChangedHistory(int $id): Collection;

    public function createReportChangedHistory(int $id): ReportEditHistory;

    public function rejectReportHistory(array $rejectReportData): void;
}
