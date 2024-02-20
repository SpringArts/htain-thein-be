<?php

namespace App\Repositories\Report;

use App\Models\Report;
use App\Enums\ConfirmStatus;
use App\Interfaces\Report\ReportInterface;

class ReportRepository implements ReportInterface
{
    public function getAllReports()
    {
        return Report::with('reporter', 'verifier', 'noti', 'editHistory')->orderBy('created_at', 'desc')->get();
    }

    public function getAllVerifiedReports(int $limit, int $page)
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
        return $report->update($data);
    }

    public function deleteReport(Report $report)
    {
        return $report->delete();
    }

    public function uncheckReport()
    {
        return Report::where('confirm_status', ConfirmStatus::UNCHECKED)->get();
    }

    public function acceptReport(Report $report)
    {
        return $report->update([
            'verifier_id' => auth()->user()->id,
            'confirm_status' => ConfirmStatus::CHECKED
        ]);
    }

    public function calculationFinancial()
    {
    }

    public function reportFilter(array $filters, int $limit, int $page)
    {
        $query = Report::query();

        try {
            if (!empty($filters['generalSearch'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('amount', 'like', '%' . $filters['generalSearch'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['generalSearch'] . '%')
                        ->orWhere('type', 'like', '%' . $filters['type'] . '%');
                });
            }

            if (!empty($filters['reporter'])) {
                $query->where('reporter_id', '=', $filters['reporter']);
            }

            if (!empty($filters['verifier'])) {
                $query->where('verifier_id', '=', $filters['verifier']);
            }

            if (!empty($filters['confirmStatus'])) {
                $query->where('confirm_status', '=', $filters['confirmStatus']);
            }

            if (!empty($filters['type'])) {
                $query->where('type', '=', $filters['type']);
            }

            $data = $query->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page)
                ->withQueryString();

            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function userReportDownload(int $userId)
    {
        return Report::with('reporter', 'verifier')->where('reporter_id', $userId);
    }
}
