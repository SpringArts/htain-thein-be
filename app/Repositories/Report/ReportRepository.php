<?php


namespace App\Repositories\Report;

use App\Models\Report;
use App\Enums\ConfirmStatus;
use App\Interfaces\Report\ReportInterface;

class ReportRepository implements ReportInterface
{
    public function getAllReports(int $limit, int $page)
    {
        return Report::where('verifier_id', '!=', '')
            ->where('confirm_status', ConfirmStatus::CHECKED)
            ->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function getReport(int $id)
    {
        return Report::findOrFail($id);
    }

    public function createReport(array $data)
    {
        return  Report::create($data);
    }

    public function updateReport(array $data, Report $report)
    {
    }

    public function deleteReport(Report $report)
    {
        return $report->delete();
    }

    public function uncheckReport()
    {
        return Report::where('confirm_status', 0)->get();
    }

    public function acceptReport(Report $report)
    {
        return $report->update([
            'verifier_id' => auth()->user()->id,
            'confirm_status' => 1
        ]);
    }

    public function calculationFinancial()
    {
    }
}
