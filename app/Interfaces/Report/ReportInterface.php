<?php

namespace App\Interfaces\Report;

use App\Models\Report;

interface ReportInterface
{
    public function getAllReports();
    public function getAllVerifiedReports(int $limit, int $page);
    public function getReport(int $id);
    public function createReport(array $data);
    public function updateReport(array $data, Report $report);
    public function deleteReport(Report $report);
    public function uncheckReport(int $limit, int $page);
    public function acceptReport(Report $report);
    public function calculationFinancial();
    public function reportFilter(array $filters, int $limit, int $page);
    public function userReportDownload(int $id);
}
