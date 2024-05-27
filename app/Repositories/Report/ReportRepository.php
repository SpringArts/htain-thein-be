<?php

namespace App\Repositories\Report;

use App\Models\Report;
use App\Enums\ConfirmStatus;
use App\Interfaces\Report\ReportInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReportRepository implements ReportInterface
{
    public function getAllReports(): Collection
    {
        return Report::with('reporter', 'verifier', 'noti', 'editHistory')->orderBy('created_at', 'desc')->get();
    }

    public function getAllVerifiedReports(int $limit, int $page): LengthAwarePaginator
    {
        return Report::where('verifier_id', '!=', '')
            ->where('confirm_status', ConfirmStatus::CHECKED)
            ->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)->withQueryString();
    }

    public function getReport(int $id): Report
    {
        return Report::findOrFail($id);
    }

    public function createReport(array $data): Report
    {
        return  Report::create($data);
    }

    public function updateReport(array $data, Report $report): bool
    {
        return $report->update($data);
    }

    public function deleteReport(Report $report): bool|null
    {
        return $report->delete();
    }

    public function uncheckReport(int $limit, int $page): LengthAwarePaginator
    {
        return Report::with('reporter', 'verifier')->where('confirm_status', ConfirmStatus::UNCHECKED)->orderBy('created_at', 'desc')->paginate($limit, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function acceptReport(Report $report): bool
    {
        return $report->update([
            'verifier_id' => getAuthUserOrFail()->id,
            'confirm_status' => ConfirmStatus::CHECKED
        ]);
    }

    public function reportFilter(array $validatedData): LengthAwarePaginator
    {
        $query = Report::query();
        $limit = $validatedData['limit'] ?? 3;
        $page = $validatedData['page'] ?? 1;
        $generalSearch = $validatedData['generalSearch'] ?? null;
        $amount = $validatedData['amount'] ?? null;
        $type = $validatedData['type'] ?? null;
        $confirmStatus = $validatedData['confirmStatus'] ?? null;
        $createdAt = $validatedData['createdAt'] ?? null;

        try {
            if (!empty($generalSearch)) {
                $query->where(function ($q) use ($generalSearch) {
                    $q->orWhere('description', 'like', '%' . $generalSearch . '%')
                        ->whereHas('reporter', function ($q) use ($generalSearch) {
                            $q->where('name', 'like', '%' . $generalSearch . '%');
                        })->orWhereHas('verifier', function ($q) use ($generalSearch) {
                            $q->where('name', 'like', '%' . $generalSearch . '%');
                        });
                });
            }

            if (!empty($amount)) {
                $query->where('amount', '=', $amount);
            }

            if (!empty($confirmStatus)) {
                $query->where('confirm_status', '=', $confirmStatus);
            }

            if (!empty($type)) {
                $query->where('type', '=', $type);
            }

            if (!empty($createdAt)) {
                $query->where('created_at', '=', $createdAt);
            }

            $data = $query->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $page)
                ->withQueryString();


            return $data;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function userReportDownload(int $userId): Builder
    {
        return Report::with('reporter', 'verifier')->where('reporter_id', $userId);
    }
}
