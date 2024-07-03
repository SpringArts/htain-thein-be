<?php

namespace App\Services\Reports;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ReportResource;
use App\Interfaces\Report\ReportInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UncheckReportService
{
    public function __invoke(ReportInterface $reportRepository, array $formData): JsonResponse
    {
        try {
            $limit = $formData['limit'] ?? 6;
            $page = $formData['page'] ?? 1;
            $data = $reportRepository->uncheckReport($limit, $page);
            $meta = ResponseHelper::getPaginationMeta($data);
            return response()->json([
                'data' => ReportResource::collection($data),
                'meta' => $meta,
            ]);
        } catch (\Throwable $th) {
            return ResponseHelper::fail($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
