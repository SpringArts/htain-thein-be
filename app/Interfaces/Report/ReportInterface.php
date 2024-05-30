<?php

namespace App\Interfaces\Report;

use App\Models\Report;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReportInterface
{
    public function getAllReports(): Collection;
    public function getAllVerifiedReports(int $limit, int $page): LengthAwarePaginator;
    public function getReport(int $id): Report;
    public function createReport(array $data): Report;
    public function updateReport(array $data, Report $report): bool;
    public function deleteReport(Report $report): bool|null;
    public function uncheckReport(int $limit, int $page): LengthAwarePaginator;
    public function acceptReport(Report $report): bool;
    public function reportFilter(array $validatedData): LengthAwarePaginator;
    public function userReportDownload(int $id): Builder;
}
