<?php

namespace App\Services\ReportHistory;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ReportEditHistoryResource;
use App\Interfaces\Report\ReportHistoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FetchReportHistoryService
{
    public function __invoke(ReportHistoryInterface $reportHistoryRepository, int $reportId): JsonResponse
    {
        try {
            $reportHistories = $reportHistoryRepository->getReportChangedHistory($reportId);
            return response()->json([
                'data' => ReportEditHistoryResource::collection($reportHistories),
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
