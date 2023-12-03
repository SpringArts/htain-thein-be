<?php


namespace App\Repositories;

use App\Models\Report;
use App\Interfaces\ReportInterface;

class ReportRepository implements ReportInterface
{
    public function getAllReports($limit, $page)
    {
        return Report::where('verifier_id', '!=', '')
            ->where('confirm_status', 1)
            ->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
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
