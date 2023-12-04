<?php

namespace App\Interfaces\Report;

use App\Models\Report;

interface ReportInterface
{
    public function getAllReports(int $limit, int $page);
    public function getReport(int $id);
    public function createReport(array $data);
    public function updateReport(array $data, Report $report);
    public function deleteReport(Report $report);
    public function uncheckReport();
    public function acceptReport(Report $report);
    public function calculationFinancial();
}
