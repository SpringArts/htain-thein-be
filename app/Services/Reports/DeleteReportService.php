<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Interfaces\Report\ReportInterface;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteReportService
{
    public function __invoke(ReportInterface $reportRepository, Report $report): JsonResponse
    {
        try {
            $reportRepository->deleteReport($report);
            return ResponseHelper::success('Report deleted successfully', null, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
