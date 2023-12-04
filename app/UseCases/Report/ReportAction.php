<?php

namespace App\UseCases\Report;

use App\Models\Report;
use App\Enums\FinancialType;
use Illuminate\Http\Response;
use App\Models\ReportEditHistory;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Report\ReportInterface;
use App\Services\FinancialCalculatorService;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Interfaces\Notification\NotificationInterface;


class ReportAction
{
    private ReportInterface $reportRepository;
    private ReportHistoryInterface $reportHistoryRepository;
    private NotificationInterface $notificationRepository;

    public function __construct(ReportInterface $reportRepository, ReportHistoryInterface $reportHistoryRepository, NotificationInterface $notificationRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->reportHistoryRepository = $reportHistoryRepository;
        $this->notificationRepository = $notificationRepository;
    }

    //fetch all reports
    public function fetchData(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $limit = request()->limit ?? 8;
        $page = request()->page ?? 1;
        $data = $this->reportRepository->getAllReports($limit, $page);
        return $data;
    }

    //create report depend on financial condition
    public function createReport(array $data): Report
    {
        if ($data['type'] == FinancialType::EXPENSE) {
            if (FinancialCalculatorService::calculateAvailableBalance() < $data['amount']) {
                throw new \Exception(FinancialCalculatorService::calculateAvailableBalance() . ' kyat is only available.');
            }
        }
        return $this->reportRepository->createReport($data);
    }

    //update report
    public function updateReport(ReportRequest $request, Report $report): int
    {
        $oldData = $report->toArray();
        $this->reportRepository->updateReport($request->all(), $report);
        $newData = $report->toArray();
        $this->editHistory($oldData, $newData);
        return Response::HTTP_OK;
    }

    //uncheck report
    public function uncheckReport(): Collection
    {
        return $this->reportRepository->uncheckReport();
    }

    //accept report
    public function acceptReport(Report $report): int
    {
        $this->reportRepository->acceptReport($report);
        $notification = $this->notificationRepository->getUserNotification($report);
        if (!$notification) {
            throw new \Exception('Notification not found');
        }
        return  $this->notificationRepository->updateNotification($notification);
    }

    //calculation financial
    public function calculationFinancial(): array
    {
        $overviewData = FinancialCalculatorService::overviewCalculate();
        return $overviewData;
    }

    //delete report
    public function deleteReport(Report $report): int
    {
        return $this->reportRepository->deleteReport($report);
    }

    //fetch report changed history
    public function fetchChangedHistory()
    {
        return $this->reportHistoryRepository->getAllReportChangedHistories();
    }

    //create notification after report created
    public function createNotification(int $userId, int $reportId)
    {
        return $this->notificationRepository->createNotification($userId, $reportId);
    }

    //create report history after report rejected
    public function createReportHistory(int $id)
    {
        $report = $this->getReport($id);
        $this->rejectReport($report);
        $this->updateNotification($report);
        return $this->reportRepository->deleteReport($report);
    }

    //fetch single report
    private function getReport(int $id)
    {
        $report = $this->reportRepository->getReport($id);
        if (!$report) {
            throw new \Exception('Report not found');
        }
        return $report;
    }

    //update notification after report rejected
    private function updateNotification($report)
    {
        $noti = $this->notificationRepository->getUserNotification($report);
        if ($noti) {
            $this->notificationRepository->updateNotification($noti);
        }
    }

    //create report history after report rejected
    private function rejectReport($report)
    {
        $rejectReportData = [
            'amount' => $report->amount,
            'description' => $report->description,
            'type' => $report->type,
            'reporter_id' => $report->reporter_id,
            'rejecter_id' => auth()->user()->id,
        ];
        // Create the cancel report history entry
        $this->reportHistoryRepository->rejectReportHistory($rejectReportData);
    }

    //create report history after report updated
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
