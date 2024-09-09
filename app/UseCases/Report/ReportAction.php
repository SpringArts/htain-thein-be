<?php

namespace App\UseCases\Report;

use App\Interfaces\Notification\NotificationInterface;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use App\Services\Reports\AcceptReportService;
use App\Services\ReportHistory\CreateReportHistoryService;
use App\Services\Reports\FinancialCalculatorService;
use App\Services\Reports\CreateReportService;
use App\Services\Reports\DeleteReportService;
use App\Services\Reports\EditReportService;
use App\Services\Reports\FetchFilterReportService;
use App\Services\ReportHistory\FetchReportHistoryService;
use App\Services\Reports\UncheckReportService;
use App\UseCases\NotiInfo\NotiInfoAction;
use Illuminate\Http\JsonResponse;

class ReportAction
{
    private ReportInterface $reportRepository;
    private ReportHistoryInterface $reportHistoryRepository;
    private NotificationInterface $notificationRepository;
    private NotiInfoAction $notiInfoAction;

    public function __construct(
        ReportInterface $reportRepository,
        ReportHistoryInterface $reportHistoryRepository,
        NotificationInterface $notificationRepository,
        NotiInfoAction $notiInfoAction
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportHistoryRepository = $reportHistoryRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notiInfoAction = $notiInfoAction;
    }

    public function fetchFilterData(array $validatedData): JsonResponse
    {
        return (new FetchFilterReportService())($this->reportRepository, $validatedData);
    }

    //create report depend on financial condition
    public function createReport(array $data): JsonResponse
    {
        return (new CreateReportService())($data, $this->reportRepository, $this->notiInfoAction);
    }

    //update report
    public function updateReport(array $formData, Report $report): JsonResponse
    {
        return (new EditReportService())($formData, $this->reportRepository, $this->notiInfoAction, $report);
    }

    //uncheck report
    public function uncheckReport(array $formData): JsonResponse
    {
        return (new UncheckReportService())($this->reportRepository, $formData);
    }

    //accept report
    public function acceptReport(Report $report): JsonResponse
    {
        return (new AcceptReportService())($this->reportRepository, $report, $this->notificationRepository);
    }

    //calculation financial
    public function calculationFinancial(): array
    {
        $overviewData = FinancialCalculatorService::overviewCalculate();
        return $overviewData;
    }

    //delete report
    public function deleteReport(Report $report): JsonResponse
    {
        return (new DeleteReportService())($this->reportRepository, $report);
    }

    //fetch report changed history
    public function fetchChangedHistory(int $reportId): JsonResponse
    {
        return (new FetchReportHistoryService())($this->reportHistoryRepository, $reportId);
    }

    //create report history after report rejected
    public function createReportHistory(int $id): JsonResponse
    {
        return (new CreateReportHistoryService($this->reportRepository, $this->reportHistoryRepository))($id);
    }
}
