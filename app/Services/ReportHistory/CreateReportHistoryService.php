<?php

namespace App\Services\ReportHistory;

use App\Helpers\ResponseHelper;
use App\Interfaces\Report\ReportHistoryInterface;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CreateReportHistoryService
{
    private ReportInterface $reportRepository;
    private ReportHistoryInterface $reportHistoryRepository;

    public function __construct(ReportInterface $reportRepository, ReportHistoryInterface $reportHistoryRepository)
    {
        $this->reportRepository = $reportRepository;
        $this->reportHistoryRepository = $reportHistoryRepository;
    }

    public function __invoke(int $reportId): JsonResponse
    {
        try {
            $report = $this->getReport($reportId);
            $this->rejectReport($report);
            $this->reportRepository->deleteReport($report); //TODO CHECK FUNCTION
            return ResponseHelper::success('Report deleted successfully', null, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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
