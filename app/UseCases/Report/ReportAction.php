<?php

namespace App\UseCases\Report;

use App\Enums\FinancialType;
use App\Exceptions\CustomErrorException;
use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Interfaces\Report\ReportInterface;
use App\Models\NotiInfo;
use App\Models\Report;
use App\Services\FinancialCalculatorService;
use App\Services\ReportEditHistoryService;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ReportAction
{
    private ReportInterface $reportRepository;

    private ReportHistoryInterface $reportHistoryRepository;

    private NotificationInterface $notificationRepository;

    private ReportEditHistoryService $reportEditHistoryService;

    private NotiInfoAction $notiInfoAction;

    public function __construct(
        ReportInterface $reportRepository,
        ReportHistoryInterface $reportHistoryRepository,
        NotificationInterface $notificationRepository,
        ReportEditHistoryService $reportEditHistoryService,
        NotiInfoAction $notiInfoAction
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportHistoryRepository = $reportHistoryRepository;
        $this->notificationRepository = $notificationRepository;
        $this->reportEditHistoryService = $reportEditHistoryService;
        $this->notiInfoAction = $notiInfoAction;
    }

    public function fetchAllReports(): Collection
    {
        return $this->reportRepository->getAllReports();
    }

    public function fetchFilterData(array $validatedData): LengthAwarePaginator
    {
        return $this->reportRepository->reportFilter($validatedData);
    }

    //create report depend on financial condition
    public function createReport(array $data): Report
    {
        $authUserId = getAuthUserOrFail()->id;
        if ($data['type'] == FinancialType::EXPENSE) {
            if (FinancialCalculatorService::calculateAvailableBalance() < $data['amount']) {
                if (FinancialCalculatorService::calculateAvailableBalance() <= 0) {
                    throw new CustomErrorException('Current Income is ( 0 ) balance.You cannot withdraw.', Response::HTTP_BAD_REQUEST);
                }
                throw new CustomErrorException(FinancialCalculatorService::calculateAvailableBalance().' kyat is only available.', Response::HTTP_BAD_REQUEST);
            }
        }
        $report = $this->reportRepository->createReport($data);
        $this->notiInfoAction->createNotification([
            'user_id' => $authUserId,
            'report_id' => $report->id,
            'type' => 'report',
        ]);

        return $report;
    }

    //update report
    public function updateReport(array $formData, Report $report): int
    {
        $oldData = $report->toArray();
        $this->reportRepository->updateReport($formData, $report);
        $newData = $report->toArray(); //take new data after update
        $this->reportEditHistoryService->editHistory($oldData, $newData);

        return Response::HTTP_OK;
    }

    //uncheck report
    public function uncheckReport(array $formData): LengthAwarePaginator
    {
        $limit = $formData['limit'] ?? 6;
        $page = $formData['page'] ?? 1;

        return $this->reportRepository->uncheckReport($limit, $page);
    }

    //accept report
    public function acceptReport(Report $report): NotiInfo
    {
        $this->reportRepository->acceptReport($report);
        $notification = $this->notificationRepository->getUserNotification($report);

        return $notification;
    }

    //calculation financial
    public function calculationFinancial(): array
    {
        $overviewData = FinancialCalculatorService::overviewCalculate();

        return $overviewData;
    }

    //delete report
    public function deleteReport(Report $report): ?bool
    {
        return $this->reportRepository->deleteReport($report);
    }

    //fetch report changed history
    public function fetchChangedHistory(int $reportId): Collection
    {
        return $this->reportHistoryRepository->getReportChangedHistory($reportId);
    }

    //create report history after report rejected
    public function createReportHistory(int $id): ?bool
    {
        $report = $this->getReport($id);
        $this->rejectReport($report);

        return $this->reportRepository->deleteReport($report); //TODO CHECK FUNCTION
    }

    //fetch single report
    private function getReport(int $id): Report
    {
        $report = $this->reportRepository->getReport($id);

        return $report;
    }

    //create report history after report rejected
    private function rejectReport(Report $report): void
    {
        $rejectReportData = [
            'amount' => $report->amount,
            'description' => $report->description,
            'type' => $report->type,
            'reporter_id' => $report->reporter_id,
            'rejecter_id' => getAuthUserOrFail()->id,
        ];
        // Create the cancel report history entry
        $this->reportHistoryRepository->rejectReportHistory($rejectReportData);
    }
}
