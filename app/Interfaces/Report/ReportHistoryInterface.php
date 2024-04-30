<?php

namespace App\Interfaces\Report;

interface ReportHistoryInterface
{
    public function getAllReportChangedHistories();
    public function getReportChangedHistory(int $id);
    public function createReportChangedHistory(int $id);
    public function rejectReportHistory(array $rejectReportData);
}
