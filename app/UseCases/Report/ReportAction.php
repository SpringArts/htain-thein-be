<?php

namespace App\UseCases\Report;

use App\Models\Report;
use App\Models\NotiInfo;
use Illuminate\Http\Response;
use App\Models\ReportEditHistory;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReportInterface;
use App\Http\Requests\ReportRequest;
use App\Interfaces\NotificationInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Services\FinancialCalculatorService;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ReportEditHistoryInterface;
use Illuminate\Notifications\Notification;

class ReportAction
{
    private ReportInterface $reportRepository;
    private ReportEditHistoryInterface $reportEditHistoryRepository;
    private NotificationInterface $notificationRepository;

    public function __construct(ReportInterface $reportRepository, ReportEditHistoryInterface $reportEditHistoryRepository, NotificationInterface $notificationRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->reportEditHistoryRepository = $reportEditHistoryRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function fetchData(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = $this->reportRepository->getAllReports($limit, $page);
        return $data;
    }

    public function createReport(array $data): Report
    {
        if ($data['type'] == "Outcome") {
            if (FinancialCalculatorService::calculateAvailableBalance() < $data['amount']) {
                throw new \Exception(FinancialCalculatorService::calculateAvailableBalance() . ' kyat is only available.');
            }
        }
        return $this->reportRepository->createReport($data);
    }

    public function updateReport(ReportRequest $request, Report $report): int
    {
        $oldData = $report->toArray();
        $this->reportRepository->updateReport($request->all(), $report);
        $newData = $report->toArray();
        $this->editHistory($oldData, $newData);
        return Response::HTTP_OK;
    }

    public function uncheckReport(): Collection
    {
        return $this->reportRepository->uncheckReport();
    }

    public function acceptReport(Report $report): int
    {
        $this->reportRepository->acceptReport($report);
        $notification = $this->notificationRepository->getUserNotification($report);
        if (!$notification) {
            throw new \Exception('Notification not found');
        }
        return  $this->notificationRepository->updateNotification($notification);
    }

    public function calculationFinancial(): array
    {
        $overviewData = FinancialCalculatorService::overviewCalculate();
        return $overviewData;
    }

    public function deleteReport(Report $report): int
    {
        return $this->reportRepository->deleteReport($report);
    }

    public function fetchChangedHistory()
    {
        return $this->reportEditHistoryRepository->getAllReportChangedHistories();
    }

    private function editHistory(array $oldData, array $newData): void
    {
        try {
            $history = new ReportEditHistory();
            $history->editor_id = Auth::id();
            $history->report_id = $oldData['id'];

            $oldDataChangeFields = [];
            $newDataChangeFields = [];

            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] !== $value) {
                    $oldDataChangeFields[$key] = $oldData[$key];
                    $newDataChangeFields[$key] = $value;
                }
            }
            if (!empty($newDataChangeFields)) {
                $history->old_data = json_encode($oldDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                $history->new_data = json_encode($newDataChangeFields, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                $history->save();
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
