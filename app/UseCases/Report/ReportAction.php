<?php

namespace App\UseCases\Report;

use App\Helpers\ResponseHelper;
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
use Illuminate\Http\Response;
use Throwable;

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
        try {
            return (new FetchFilterReportService())($this->reportRepository, $validatedData);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //create report depend on financial condition
    public function createReport(array $data): JsonResponse
    {
        try {
            return (new CreateReportService())($data, $this->reportRepository, $this->notiInfoAction);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //update report
    public function updateReport(array $formData, Report $report): JsonResponse
    {
        try {
            return (new EditReportService())($formData, $this->reportRepository, $this->notiInfoAction, $report);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //uncheck report
    public function uncheckReport(array $formData): JsonResponse
    {
        try {
            return (new UncheckReportService())($this->reportRepository, $formData);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //accept report
    public function acceptReport(Report $report): JsonResponse
    {
        try {
            return (new AcceptReportService())($this->reportRepository, $report, $this->notificationRepository);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            return (new DeleteReportService())($this->reportRepository, $report);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //fetch report changed history
    public function fetchChangedHistory(int $reportId): JsonResponse
    {
        try {
            return (new FetchReportHistoryService())($this->reportHistoryRepository, $reportId);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    //create report history after report rejected
    public function createReportHistory(int $id): JsonResponse
    {
        try {
            return (new CreateReportHistoryService($this->reportRepository, $this->reportHistoryRepository))($id);
        } catch (Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
